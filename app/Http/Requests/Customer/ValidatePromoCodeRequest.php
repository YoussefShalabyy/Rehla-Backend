<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePromoCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'           => ['required', 'string'],
            'listing_uuid'   => ['required', 'string', 'exists:listings,uuid'],
            'checkout_cents' => ['required', 'integer', 'min:0'],
            'check_in_date'  => ['required', 'date_format:Y-m-d'],
            'check_out_date' => ['required', 'date_format:Y-m-d', 'after:check_in_date'],
        ];
    }
}
