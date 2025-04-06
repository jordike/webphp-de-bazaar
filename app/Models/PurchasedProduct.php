<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedProduct extends Model
{
    protected $fillable = [
        'user_id',
        'advertisement_id',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
