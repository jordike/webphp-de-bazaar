<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'description',
        'primary_color',
        'secondary_color',
        'background_color',
        'text_color',
        'font_family',
        'font_size',
        'logo_path'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getLogoPath()
    {
        if (!$this->logo_path) {
            return null;
        }

        return asset('storage/' . $this->logo_path);
    }
}
