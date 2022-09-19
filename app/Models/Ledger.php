<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $appends = ['formatted_amount'];

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }

    protected function formattedAmount(): Attribute
    {
        return new Attribute(
            get: fn () =>  "$" . ($this->amount / 100)
        );
    }
}
