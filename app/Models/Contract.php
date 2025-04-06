<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'is_signed',
        'pdf_path',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_signed' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getPdfPath()
    {
        if (!$this->pdf_path) {
            return null;
        }

        return storage_path('app/' . $this->pdf_path);
    }
}
