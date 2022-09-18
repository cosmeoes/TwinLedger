<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }
}
