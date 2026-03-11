<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'mobile_number',
        'loan_type',
        'city',
        'monthly_yield',
        'vehicle_make',
        'vehicle_model',
        'mfg_year',
        'fuel_type',
        'asset_value',
        'pan_number',
        'aadhaar_number',
        'documents',
        'rc_documents',
        'status',
        'loan_amount', // Keeping for backward compatibility if needed
    ];

    protected $casts = [
        'documents' => 'array',
        'rc_documents' => 'array',
        'monthly_yield' => 'decimal:2',
        'asset_value' => 'decimal:2',
        'loan_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
