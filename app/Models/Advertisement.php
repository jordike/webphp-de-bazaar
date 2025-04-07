<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'is_for_rent',
        'price',
        'photo',
        'user_id',
        'expiration_date'
    ];

    protected $casts = [
        'is_for_rent' => 'boolean',
        'expiration_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($advertisement) {
            $advertisement->expiration_date = now()->addDays(30);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function relatedAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_advertisement', 'advertisement_id', 'related_advertisement_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavorite()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    public function getPhotoUrl()
    {
        if (!$this->photo) {
            return null;
        }

        return asset('storage/' . $this->photo);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
