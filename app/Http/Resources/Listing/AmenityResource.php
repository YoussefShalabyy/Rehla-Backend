<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'en');
        $resolvedName = ($lang === 'ar' && !empty($this->name_ar)) ? $this->name_ar : $this->name;

        return [
            'id' => $this->id,
            'name' => $resolvedName,
            'name_en' => $this->name,
            'name_ar' => $this->name_ar,
            'icon' => $this->icon,
            'type' => $this->type,
        ];
    }
}
