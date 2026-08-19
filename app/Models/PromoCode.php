<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromoCode extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'discount_type'       => DiscountType::class,
            'discount_amount'     => 'integer',
            'max_discount_amount' => 'integer',
            'min_checkout_amount' => 'integer',
            'max_uses'            => 'integer',
            'used_count'          => 'integer',
            'valid_from'          => 'datetime',
            'valid_until'         => 'datetime',
            'travel_start_date'   => 'datetime',
            'travel_end_date'     => 'datetime',
            'is_active'           => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
