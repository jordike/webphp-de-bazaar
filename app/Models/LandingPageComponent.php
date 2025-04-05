<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageComponent extends Model
{
    protected $fillable = [
        'company_id',
        'type',
        'content',
        'order',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
