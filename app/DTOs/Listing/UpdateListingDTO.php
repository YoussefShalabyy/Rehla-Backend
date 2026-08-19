<?php

declare(strict_types=1);

namespace App\DTOs\Listing;

use App\Http\Requests\Listing\UpdateListingRequest;

readonly class UpdateListingDTO
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $category,
        public ?int $basePriceCents,
        public ?int $originalBasePriceCents,
        public ?int $weeklyPriceCents,
        public ?int $monthlyPriceCents,
        public ?int $cleaningFeeCents,
        public ?int $extraGuestFeeCents,
        public ?int $maxGuests,
        public ?array $amenityIds,
    ) {}

    public static function fromRequest(UpdateListingRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            category: $request->validated('category'),
            basePriceCents: $request->validated('base_price_cents') !== null ? (int) $request->validated('base_price_cents') : null,
            originalBasePriceCents: $request->validated('original_base_price_cents') !== null ? (int) $request->validated('original_base_price_cents') : null,
            weeklyPriceCents: $request->validated('weekly_price_cents') !== null ? (int) $request->validated('weekly_price_cents') : null,
            monthlyPriceCents: $request->validated('monthly_price_cents') !== null ? (int) $request->validated('monthly_price_cents') : null,
            cleaningFeeCents: $request->validated('cleaning_fee_cents') !== null ? (int) $request->validated('cleaning_fee_cents') : null,
            extraGuestFeeCents: $request->validated('extra_guest_fee_cents') !== null ? (int) $request->validated('extra_guest_fee_cents') : null,
            maxGuests: $request->validated('max_guests') ? (int) $request->validated('max_guests') : null,
            amenityIds: $request->validated('amenity_ids'),
        );
    }
}
