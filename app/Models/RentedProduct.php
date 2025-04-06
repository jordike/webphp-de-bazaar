<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'advertisement_id',
        'price',
        'start_date',
        'end_date',
        'return_date',
        'return_wear_state',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'return_date' => 'date',
        'return_wear_state' => 'integer',
        'price' => 'decimal:2',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWearState()
    {
        if ($this->return_wear_state === null) {
            return null;
        }

        return $this->return_wear_state . "%";
    }

    public function isReturned()
    {
        return $this->return_date !== null;
    }
}
