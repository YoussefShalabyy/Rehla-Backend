<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\PromoCode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\DiscountType;

class StorePromoCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'                => ['required', 'string', 'unique:promo_codes,code'],
            'scope_type'          => ['required', 'string', Rule::in(['global', 'listing_type', 'property_type', 'listing'])],
            'scope_value'         => ['nullable', 'string', 'required_unless:scope_type,global'],
            'discount_type'       => ['required', 'string', Rule::enum(DiscountType::class)],
            'discount_amount'     => ['required', 'integer', 'min:1'],
            'max_discount_amount' => ['nullable', 'integer', 'min:1'],
            'min_checkout_amount' => ['nullable', 'integer', 'min:1'],
            'max_uses'            => ['nullable', 'integer', 'min:1'],
            'valid_from'          => ['nullable', 'date'],
            'valid_until'         => ['nullable', 'date', 'after:valid_from'],
            'travel_start_date'   => ['nullable', 'date'],
            'travel_end_date'     => ['nullable', 'date', 'after:travel_start_date'],
            'is_active'           => ['boolean'],
        ];
    }
}
