<?php

namespace Tests\Feature;

use App\Models\Ledger;
use App\Models\RecurringItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecurringItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_recurring_changes()
    {
        $lender = User::factory()->create();
        $debtor = User::factory()->create();
        RecurringItem::factory()->create([
            'lender_id' => $lender->id,
            'debtor_id' => $debtor->id,
            'concept' => 'Internet',
            'amount' => 35000,
            'monthly_at' => 15,
        ]);

        RecurringItem::factory()->create([
            'lender_id' => $debtor->id,
            'debtor_id' => $lender->id,
            'concept' => 'Netflix',
            'amount' => 7500,
            'monthly_at' => 1,
        ]);

        $this->travelTo(now()->setDay(15));
        $this->artisan('add-recurring');

        $this->assertEquals(1, Ledger::count());
        $ledger = Ledger::first();
        $this->assertTrue($lender->is($ledger->lender));
        $this->assertTrue($debtor->is($ledger->debtor));
        $this->assertEquals('Internet', $ledger->concept);
        $this->assertEquals(35000, $ledger->amount);

        $this->travelTo(now()->addMonth()->setDay(1));
        $this->artisan('add-recurring');

        $this->assertEquals(2, Ledger::count());
        $ledger = Ledger::where('concept', 'Netflix')->first();
        $this->assertTrue($debtor->is($ledger->lender));
        $this->assertTrue($lender->is($ledger->debtor));
        $this->assertEquals('Netflix', $ledger->concept);
        $this->assertEquals(7500, $ledger->amount);
    }
}
