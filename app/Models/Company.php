<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
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
}
