<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Extract primary image url if loaded
        $primaryImage = null;
        if ($this->relationLoaded('media')) {
            $primaryMedia = $this->media->where('is_primary', true)->first();
            if ($primaryMedia) {
                $primaryImage = $primaryMedia->url;
            } elseif ($this->media->isNotEmpty()) {
                $primaryImage = $this->media->first()->url;
            }
        }

        $lang = $request->header('Accept-Language', 'en');
        $resolvedTitle = ($lang === 'ar' && !empty($this->title_ar)) ? $this->title_ar : $this->title;
        $resolvedCity = ($lang === 'ar' && !empty($this->city_ar)) ? $this->city_ar : $this->city;

        return [
            'uuid' => $this->uuid,
            'type' => $this->type,
            'title' => $resolvedTitle,
            'title_ar' => $this->title_ar,
            'city' => $resolvedCity,
            'city_en' => $this->city,
            'city_ar' => $this->city_ar,
            'base_price_cents' => $this->base_price_cents,
            'original_base_price_cents' => $this->original_base_price_cents,
            'weekly_price_cents' => $this->weekly_price_cents,
            'monthly_price_cents' => $this->monthly_price_cents,
            'is_instant_bookable' => $this->is_instant_bookable,
            'status' => $this->status,
            'category' => $this->category,
            'property_type' => $this->property_type,
            'year' => $this->year,
            'primary_image_url' => $primaryImage,
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->reviews_count,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'is_wishlisted' => $this->when($request->user('sanctum'), function () use ($request) {
                if ($this->relationLoaded('wishlists')) {
                    return $this->wishlists->contains('user_id', $request->user('sanctum')->id);
                }
                return $this->wishlists()->where('user_id', $request->user('sanctum')->id)->exists();
            }, false),
        ];
    }
}
