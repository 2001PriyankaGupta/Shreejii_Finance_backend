<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'loan_type',
        'monthly_income',
        'city',
        'current_city',
        'loan_amount',
        'tenure',
        'employment_status',
        'employer_name',
        'existing_emis',
        'customer_name',
        'pan_number',
        'aadhaar_number',
        'pan_image',
        'aadhaar_front_image',
        'aadhaar_back_image',
        'bank_statement',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
