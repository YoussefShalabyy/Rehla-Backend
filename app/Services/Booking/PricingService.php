<?php

declare(strict_types=1);

namespace App\Services\Booking;

use App\DTOs\Booking\PricingResultDTO;
use App\Models\Listing;
use App\Models\PlatformSetting;
use Carbon\Carbon;

class PricingService
{
    /**
     * Calculate pricing for a booking.
     * All calculations are performed in integer cents to avoid floating point errors.
     */
    public function calculate(Listing $listing, string $checkIn, string $checkOut, int $guests): PricingResultDTO
    {
        $start = Carbon::parse($checkIn);
        $end   = Carbon::parse($checkOut);

        $nights = (int) $start->diffInDays($end);

        // Ensure at least 1 night
        if ($nights < 1) {
            $nights = 1;
        }

        $months = (int) floor($nights / 30);
        $remainingDaysAfterMonths = $nights % 30;
        $weeks = (int) floor($remainingDaysAfterMonths / 7);
        $days = $remainingDaysAfterMonths % 7;

        $weeklyPrice = $listing->weekly_price_cents ?? ($listing->base_price_cents * 7);
        $monthlyPrice = $listing->monthly_price_cents ?? ($listing->base_price_cents * 30);

        $discountedBaseTotalCents = ($months * $monthlyPrice) + ($weeks * $weeklyPrice) + ($days * $listing->base_price_cents);
        
        $standardBaseTotalCents = $nights * $listing->base_price_cents;
        
        // This is the length of stay discount based on weekly/monthly rates
        $lengthOfStayDiscountCents = max(0, $standardBaseTotalCents - $discountedBaseTotalCents);
        
        // Use standardBaseTotalCents for "base_price" in the breakdown, we will explicitly subtract the discount later
        // But wait! If we do that, the subtotal is wrong. Let's just use discountedBaseTotalCents.
        // Actually, the user wants the discount shown explicitly in the price breakdown.
        // So we keep baseTotalCents as standardBaseTotalCents, and subtract lengthOfStayDiscountCents from the subtotal.
        
        $baseTotalCents = $standardBaseTotalCents;
        $cleaningFeeCents = $listing->cleaning_fee_cents ?? 0;

        $extraGuestFeeCents = 0;
        if ($guests > $listing->max_guests) {
            $extraGuests        = $guests - $listing->max_guests;
            $extraGuestFeeCents = $extraGuests * $nights * ($listing->extra_guest_fee_cents ?? 0);
        }

        $subtotalBeforeDiscount = $baseTotalCents + $cleaningFeeCents + $extraGuestFeeCents;
        $subtotal = max(0, $subtotalBeforeDiscount - $lengthOfStayDiscountCents);

        // Platform fee from settings (percentage of subtotal after discount)
        $feePercentage    = (float) PlatformSetting::get('platform_fee_percentage', 0);
        $platformFeeCents = (int) round($subtotal * $feePercentage / 100);

        $grandTotalCents = $subtotal + $platformFeeCents;

        return new PricingResultDTO(
            nights: $nights,
            baseTotalCents: $baseTotalCents,
            cleaningFeeCents: $cleaningFeeCents,
            extraGuestFeeCents: $extraGuestFeeCents,
            platformFeeCents: $platformFeeCents,
            lengthOfStayDiscountCents: $lengthOfStayDiscountCents,
            grandTotalCents: $grandTotalCents,
        );
    }
}
