<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'status',
        'payout_link_id',
        'payout_link_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
