<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{

    protected $fillable = ['title', 'description', 'is_for_rent', 'price', 'photo', 'user_id'];    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relatedAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_advertisement', 'advertisement_id', 'related_advertisement_id');
    }
}
