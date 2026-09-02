<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use App\Http\Resources\Auth\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'en');
        $resolvedTitle = ($lang === 'ar' && !empty($this->title_ar)) ? $this->title_ar : $this->title;
        $resolvedDescription = ($lang === 'ar' && !empty($this->description_ar)) ? $this->description_ar : $this->description;
        
        $resolvedAddress = ($lang === 'ar' && !empty($this->address_ar)) ? $this->address_ar : $this->address;
        $resolvedCity = ($lang === 'ar' && !empty($this->city_ar)) ? $this->city_ar : $this->city;
        $resolvedCountry = ($lang === 'ar' && !empty($this->country_ar)) ? $this->country_ar : $this->country;

        return [
            'uuid' => $this->uuid,
            'type' => $this->type,
            'property_type' => $this->property_type,
            'category' => $this->category,
            'title' => $resolvedTitle,
            'title_ar' => $this->title_ar,
            'description' => $resolvedDescription,
            'description_ar' => $this->description_ar,
            'address' => $resolvedAddress,
            'address_en' => $this->address,
            'address_ar' => $this->address_ar,
            'city' => $resolvedCity,
            'city_en' => $this->city,
            'city_ar' => $this->city_ar,
            'country' => $resolvedCountry,
            'country_en' => $this->country,
            'country_ar' => $this->country_ar,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'base_price_cents' => $this->base_price_cents,
            'original_base_price_cents' => $this->original_base_price_cents,
            'weekly_price_cents' => $this->weekly_price_cents,
            'monthly_price_cents' => $this->monthly_price_cents,
            'cleaning_fee_cents' => $this->cleaning_fee_cents,
            'extra_guest_fee_cents' => $this->extra_guest_fee_cents,
            'max_guests' => $this->max_guests,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'year' => $this->year,
            'status' => $this->status,
            'is_instant_bookable' => $this->is_instant_bookable,
            
            // Relationships
            'owner' => new AuthUserResource($this->whenLoaded('owner')),
            'amenities' => AmenityResource::collection($this->whenLoaded('amenities')),
            'media' => $this->whenLoaded('media', function () {
                return $this->media->map(function ($m) {
                    return [
                        'uuid' => $m->uuid,
                        'url' => $m->url,
                        'type' => $m->type,
                        'is_primary' => $m->is_primary,
                        'order' => $m->order,
                    ];
                });
            }),
            
            // Computed fields (mocked for now, will be implemented with Reviews phase)
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->reviews_count,
            'latest_reviews' => $this->whenLoaded('reviews', function () {
                return \App\Http\Resources\Review\ReviewResource::collection($this->reviews);
            }),
            'availabilities' => $this->whenLoaded('availabilityBlocks', function () {
                return $this->availabilityBlocks->map(function ($block) {
                    return [
                        'id' => $block->id,
                        'start_date' => $block->start_date->format('Y-m-d'),
                        'end_date' => $block->end_date->format('Y-m-d'),
                        'reason' => $block->reason,
                    ];
                });
            }),
            'is_wishlisted' => $this->when($request->user('sanctum'), function () use ($request) {
                if ($this->relationLoaded('wishlists')) {
                    return $this->wishlists->contains('user_id', $request->user('sanctum')->id);
                }
                return $this->wishlists()->where('user_id', $request->user('sanctum')->id)->exists();
            }, false),
        ];
    }
}
