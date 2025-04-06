<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function currentTheme()
    {
        return $this->belongsTo(Theme::class, 'current_theme_id');
    }

    public function landingPageComponents()
    {
        return $this->hasMany(LandingPageComponent::class);
    }

    public function advertisements()
    {
        return $this->hasManyThrough(Advertisement::class, User::class);
    }
}
