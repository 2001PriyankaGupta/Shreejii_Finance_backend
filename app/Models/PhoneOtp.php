<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhoneOtp extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'otp', 'expires_at'];
}
