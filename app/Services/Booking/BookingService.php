<?php

declare(strict_types=1);

namespace App\Services\Booking;

use App\DTOs\Booking\CreateBookingDTO;
use App\DTOs\Booking\CancelBookingDTO;
use App\Enums\BookingStatus;
use App\Enums\ListingStatus;
use App\Exceptions\BookingConflictException;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\PlatformSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\Notification\NotificationService;
use App\Services\PromoCode\PromoCodeService;
use App\Models\PromoCode;

class BookingService
{
    public function __construct(
        private readonly AvailabilityService $availabilityService,
        private readonly PricingService $pricingService,
        private readonly NotificationService $notificationService,
        private readonly PromoCodeService $promoCodeService,
    ) {
    }

    /**
     * Create a new booking atomically.
     * Prevents race conditions by locking the listing row for update.
     */
    public function createBooking(CreateBookingDTO $dto, User $customer): Booking
    {
        return DB::transaction(function () use ($dto, $customer) {
            if ($customer->status === \App\Enums\UserStatus::Suspended) {
                throw new HttpException(403, 'An error occurred while processing your booking. Please try again later.');
            }

            // 1. Find Listing and lock it for update
            $listing = Listing::where('uuid', $dto->listingUuid)->lockForUpdate()->first();

            if (! $listing) {
                throw new NotFoundHttpException('Listing not found.');
            }

            if ($listing->status !== ListingStatus::Active) {
                throw new HttpException(422, 'Listing is not available for booking.');
            }

            if ($dto->guestsCount > $listing->max_guests) {
                throw new HttpException(422, 'Guests count exceeds the maximum allowed for this listing.');
            }

            // 2. Check Availability inside the lock
            $isAvailable = $this->availabilityService->isAvailable(
                $listing,
                $dto->checkInDate,
                $dto->checkOutDate
            );

            if (! $isAvailable) {
                throw new BookingConflictException('The requested dates are not available.');
            }

            // 3. Calculate Pricing
            $pricing = $this->pricingService->calculate(
                $listing,
                $dto->checkInDate,
                $dto->checkOutDate,
                $dto->guestsCount
            );

            // 4. Promo Code Logic
            $promoCode = null;
            $discountAmountCents = 0;
            
            if ($dto->promoCode) {
                $promoCode = PromoCode::where('code', $dto->promoCode)->lockForUpdate()->first();
                if (! $promoCode) {
                    throw new HttpException(422, 'Invalid promo code.');
                }
                
                // This validates everything including scope and min checkout amount
                $this->promoCodeService->validate($promoCode, $listing, $customer, $pricing->grandTotalCents, $dto->checkInDate, $dto->checkOutDate);
                
                $discountAmountCents = $this->promoCodeService->calculateDiscount($promoCode, $pricing->grandTotalCents);
                
                // Increment used count
                $promoCode->increment('used_count');
            }
            
            $finalTotalCents = max(0, $pricing->grandTotalCents - $discountAmountCents);

            // 5. Create Booking with persisted pricing snapshot
            $booking = Booking::create([
                'listing_id'            => $listing->id,
                'customer_id'           => $customer->id,
                'check_in_date'         => $dto->checkInDate,
                'check_out_date'        => $dto->checkOutDate,
                'guests_count'          => $dto->guestsCount,
                'total_amount_cents'    => $finalTotalCents,
                'platform_fee_cents'    => $pricing->platformFeeCents,
                'promo_code_id'         => $promoCode?->id,
                'length_of_stay_discount_cents' => $pricing->lengthOfStayDiscountCents,
                'discount_amount_cents' => $discountAmountCents,
                'notes'                 => $dto->notes,
                'status'                => BookingStatus::Pending,
                'payment_status'        => \App\Enums\PaymentStatus::Pending,
                'pricing_snapshot'      => [
                    'nights'                => $pricing->nights,
                    'base_total_cents'      => $pricing->baseTotalCents,
                    'cleaning_fee_cents'    => $pricing->cleaningFeeCents,
                    'extra_guest_fee_cents' => $pricing->extraGuestFeeCents,
                    'platform_fee_cents'    => $pricing->platformFeeCents,
                    'length_of_stay_discount_cents' => $pricing->lengthOfStayDiscountCents,
                    'discount_amount_cents' => $discountAmountCents,
                    'promo_code'            => $promoCode?->code,
                    'grand_total_cents'     => $finalTotalCents,
                ],
            ]);

            $this->notificationService->notifyNewBooking($booking);

            return $booking;
        });
    }

    public function findByUuid(string $uuid): Booking
    {
        $booking = Booking::where('uuid', $uuid)->first();
        if (! $booking) {
            throw new NotFoundHttpException('Booking not found.');
        }
        return $booking;
    }

    /**
     * Cancel an existing booking
     */
    public function cancelBooking(Booking $booking, User $requester, string $reason): Booking
    {
        if (in_array($booking->status, [BookingStatus::Completed, BookingStatus::Cancelled])) {
            throw new HttpException(422, 'Booking cannot be cancelled in its current state.');
        }

        $windowDays = (int) PlatformSetting::get('cancellation_window_days', 7);
        $checkIn = Carbon::parse($booking->check_in_date);

        if ($windowDays === 0) {
            throw new HttpException(422, 'Cancellations are not allowed.');
        }

        if (now()->addDays($windowDays)->isAfter($checkIn)) {
            throw new HttpException(422, "Bookings can only be cancelled at least {$windowDays} days before check-in.");
        }

        $booking->update([
            'status'              => BookingStatus::Cancelled,
            'cancellation_reason' => $reason,
        ]);

        $this->notificationService->notifyBookingCancelled($booking);

        return $booking;
    }

    /**
     * Confirm a booking (called internally after payment or manual confirmation)
     */
    public function confirmBooking(Booking $booking): Booking
    {
        if ($booking->status !== BookingStatus::Pending) {
            throw new HttpException(422, 'Only pending bookings can be confirmed.');
        }

        $booking->update([
            'status' => BookingStatus::Confirmed,
        ]);

        return $booking;
    }

    /**
     * Complete a booking (e.g. after check-out date passes)
     */
    public function completeBooking(Booking $booking): Booking
    {
        if (! in_array($booking->status, [BookingStatus::Confirmed, BookingStatus::Active])) {
            throw new HttpException(422, 'Only confirmed or active bookings can be completed.');
        }

        $booking->update([
            'status' => BookingStatus::Completed,
        ]);

        return $booking;
    }

    /**
     * Reschedule an existing booking
     */
    public function rescheduleBooking(Booking $booking, string $newCheckIn, string $newCheckOut, User $requester): Booking
    {
        if (! in_array($booking->status, [BookingStatus::Pending, BookingStatus::Confirmed])) {
            throw new HttpException(422, 'Only pending or confirmed bookings can be rescheduled.');
        }

        // Recalculate price
        $listing = $booking->listing;
        
        $pricing = $this->pricingService->calculate(
            $listing,
            $newCheckIn,
            $newCheckOut,
            $booking->guests_count
        );

        $booking->update([
            'check_in_date'      => $newCheckIn,
            'check_out_date'     => $newCheckOut,
            'total_amount_cents' => $pricing->grandTotalCents,
            'platform_fee_cents' => $pricing->platformFeeCents,
        ]);

        return $booking;
    }
}
