<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EliteApplication extends Model
{
    protected $fillable = [
        'user_id',
        'score',
        'interest_rate',
        'loan_limit',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
