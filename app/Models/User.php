<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'employee_id',
        'role',
        'avatar_url',
        'location',
        'status',
        'password',
        'credit_score',
        'bank_name',
        'account_number',
        'ifsc_code',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class);
    }

    public function employeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    // Accessors for bank details to fallback to employeeDetail
    public function getBankNameAttribute($value)
    {
        return $value ?: optional($this->employeeDetail)->bank_name;
    }

    public function getAccountNumberAttribute($value)
    {
        return $value ?: optional($this->employeeDetail)->account_number;
    }

    public function getIfscCodeAttribute($value)
    {
        return $value ?: optional($this->employeeDetail)->ifsc_code;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'location' => 'array',
        ];
    }
}
