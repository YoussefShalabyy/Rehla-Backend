<?php

declare(strict_types=1);

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === \App\Enums\UserRole::Admin;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:property,car'],
            'property_type' => ['nullable', 'in:hotel,apartment,villa,room'],
            'category' => ['nullable', 'in:luxury,sports,suv,economy,daily'],
            'title' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_ar' => ['nullable', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'base_price_cents' => 'required_without_all:weekly_price_cents,monthly_price_cents|nullable|integer|min:0',
            'original_base_price_cents' => 'nullable|integer|min:0',
            'weekly_price_cents' => 'required_without_all:base_price_cents,monthly_price_cents|nullable|integer|min:0',
            'monthly_price_cents' => 'required_without_all:base_price_cents,weekly_price_cents|nullable|integer|min:0',
            'cleaning_fee_cents' => 'nullable|integer|min:0',
            'extra_guest_fee_cents' => 'nullable|integer|min:0',
            'max_guests' => ['required', 'integer', 'min:1'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'numeric', 'min:0'],
            'transmission' => ['nullable', 'string', 'max:255'],
            'fuel_type' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1990', 'max:2030'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
        ];
    }
}
