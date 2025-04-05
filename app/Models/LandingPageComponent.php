<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageComponent extends Model
{
    public const TYPE_TEXT = 'text';
    public const TYPE_IMAGE = 'image';
    public const TYPE_HIGHLIGHTED_ADVERTISEMENTS = 'highlighted_advertisements';

    protected $fillable = [
        'company_id',
        'type',
        'content',
        'order',
    ];

    public static function getAllowedTypes(): array
    {
        return [
            self::TYPE_TEXT,
            self::TYPE_IMAGE,
            self::TYPE_HIGHLIGHTED_ADVERTISEMENTS,
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->type === 'image' ? asset('storage/' . $this->content) : null;
    }
}
