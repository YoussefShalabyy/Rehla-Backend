<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'listing_id',
        'check_in_date',
        'check_out_date',
        'step',
        'device_id',
        'guests_count',
        'is_read',
        'status',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
