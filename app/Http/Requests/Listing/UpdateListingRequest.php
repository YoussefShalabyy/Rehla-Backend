<?php

declare(strict_types=1);

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Policy will handle this authorization via the controller
        return true; 
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'in:luxury,sports,family,economy'],
            'base_price_cents' => ['sometimes', 'integer', 'min:0'],
            'original_base_price_cents' => ['nullable', 'integer', 'min:0'],
            'weekly_price_cents' => ['nullable', 'integer', 'min:0'],
            'monthly_price_cents' => ['nullable', 'integer', 'min:0'],
            'cleaning_fee_cents' => ['nullable', 'integer', 'min:0'],
            'extra_guest_fee_cents' => ['nullable', 'integer', 'min:0'],
            'max_guests' => ['nullable', 'integer', 'min:1'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
        ];
    }
}
