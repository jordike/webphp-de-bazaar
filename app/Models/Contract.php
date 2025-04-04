<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'company_id',
        'is_signed',
        'pdf_path',
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
