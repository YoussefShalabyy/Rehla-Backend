<?php

namespace App\Http\Resources\Destination;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'en');
        $resolvedName = ($lang === 'ar' && !empty($this->name_ar)) ? $this->name_ar : $this->name;
        $resolvedSubtitle = ($lang === 'ar' && !empty($this->subtitle_ar)) ? $this->subtitle_ar : $this->subtitle;
        $resolvedCountry = ($lang === 'ar' && !empty($this->country_ar)) ? $this->country_ar : $this->country;

        return [
            'uuid' => $this->uuid,
            'name' => $resolvedName,
            'name_en' => $this->name,
            'name_ar' => $this->name_ar,
            'country' => $resolvedCountry,
            'country_en' => $this->country,
            'country_ar' => $this->country_ar,
            'subtitle' => $resolvedSubtitle,
            'subtitle_en' => $this->subtitle,
            'subtitle_ar' => $this->subtitle_ar,
            'icon' => $this->icon,
            'icon_color' => $this->icon_color,
            'icon_bg' => $this->icon_bg,
            'image_url' => $this->image_url,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'listings_count' => $this->whenCounted('listings'),
        ];
    }
}
