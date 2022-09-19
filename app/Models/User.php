<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['credit'];

    public function credits()
    {
        return $this->hasMany(Ledger::class, 'lender_id');
    }

    public function debts()
    {
        return $this->hasMany(Ledger::class, 'debtor_id');
    }

    public function credit(): Attribute
    {
        return new Attribute(
            get: fn() => $this->credits()->sum('amount') - $this->debts()->sum('amount')
        );
    }
}
