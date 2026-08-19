<?php

declare(strict_types=1);

namespace App\Services\PromoCode;

use App\Enums\DiscountType;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\PromoCode;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PromoCodeService
{
    /**
     * Calculate discount amount.
     * Does NOT check validity, just raw calculation.
     */
    public function calculateDiscount(PromoCode $promoCode, int $baseAmountCents): int
    {
        if ($promoCode->discount_type === DiscountType::FixedAmount) {
            return min($baseAmountCents, $promoCode->discount_amount);
        }

        // Percentage
        $discount = (int) round($baseAmountCents * ($promoCode->discount_amount / 100));

        if ($promoCode->max_discount_amount !== null && $promoCode->max_discount_amount > 0) {
            $discount = min($discount, $promoCode->max_discount_amount);
        }

        return min($baseAmountCents, $discount);
    }

    /**
     * Validate if a promo code is applicable to the given booking scenario.
     * Throws HttpException on failure.
     */
    public function validate(PromoCode $promoCode, Listing $listing, User $user, int $checkoutAmountCents, string $checkInDate, string $checkOutDate): void
    {
        if (! $promoCode->is_active) {
            throw new HttpException(422, 'This promo code is inactive.');
        }

        if ($promoCode->valid_from && Carbon::now()->isBefore($promoCode->valid_from)) {
            throw new HttpException(422, 'This promo code is not yet valid.');
        }

        if ($promoCode->valid_until && Carbon::now()->isAfter($promoCode->valid_until)) {
            throw new HttpException(422, 'This promo code has expired.');
        }

        $checkIn = Carbon::parse($checkInDate)->startOfDay();
        $checkOut = Carbon::parse($checkOutDate)->startOfDay();

        if ($promoCode->travel_start_date) {
            $travelStart = Carbon::parse($promoCode->travel_start_date)->startOfDay();
            if ($checkIn->isBefore($travelStart)) {
                $formattedDate = $travelStart->format('Y-m-d');
                throw new HttpException(422, "This promo code is only valid for stays starting from {$formattedDate}.");
            }
        }

        if ($promoCode->travel_end_date) {
            $travelEnd = Carbon::parse($promoCode->travel_end_date)->startOfDay();
            if ($checkOut->isAfter($travelEnd)) {
                $formattedDate = $travelEnd->format('Y-m-d');
                throw new HttpException(422, "This promo code is only valid for stays ending by {$formattedDate}.");
            }
        }

        if ($promoCode->max_uses !== null && $promoCode->used_count >= $promoCode->max_uses) {
            throw new HttpException(422, 'This promo code has reached its maximum number of uses.');
        }

        if ($promoCode->min_checkout_amount !== null && $checkoutAmountCents < $promoCode->min_checkout_amount) {
            $formattedMin = number_format($promoCode->min_checkout_amount / 100, 2);
            throw new HttpException(422, "This promo code requires a minimum checkout amount of {$formattedMin}.");
        }

        // Check Target Scope
        if ($promoCode->scope_type === 'listing_type' && $promoCode->scope_value) {
            if ($listing->type->value !== $promoCode->scope_value) {
                throw new HttpException(422, 'This promo code is not valid for this type of listing.');
            }
        } elseif ($promoCode->scope_type === 'property_type' && $promoCode->scope_value) {
            if ($listing->property_type?->value !== $promoCode->scope_value) {
                throw new HttpException(422, 'This promo code is not valid for this property category.');
            }
        } elseif ($promoCode->scope_type === 'listing' && $promoCode->scope_value) {
            // scope_value stores the listing UUID
            if ((string) $listing->uuid !== (string) $promoCode->scope_value) {
                throw new HttpException(422, 'This promo code is not valid for this specific listing.');
            }
        }

        // Per-User Limit: Check if the user has already used this code in a confirmed/pending/completed booking.
        $hasUsed = Booking::where('customer_id', $user->id)
            ->where('promo_code_id', $promoCode->id)
            ->whereIn('status', [\App\Enums\BookingStatus::Pending, \App\Enums\BookingStatus::Confirmed, \App\Enums\BookingStatus::Active, \App\Enums\BookingStatus::Completed])
            ->exists();

        if ($hasUsed) {
            throw new HttpException(422, 'You have already used this promo code.');
        }
    }
}
