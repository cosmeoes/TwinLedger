<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RecurringItem extends Model
{

    use HasFactory;

    public $guarded = [];

    protected $appends = ['formatted_amount', 'next_charge', 'end_date'];

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

    protected function nextCharge(): Attribute
    {
        return new Attribute(
            get: function() {
                $currentMonth = now()->setDay($this->monthly_at)->setHour(12);
                if (now()->isBefore($currentMonth)) {
                    return $currentMonth;
                }

                return now()->addMonth()->setDay($this->monthly_at)->setHour(12);
            }
        );
    }

    protected function endDate(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!$this->ends_at) {
                    return null;
                }

                return now()->parse($this->ends_at)->setHour(12);
            }
        );
    }
}
