<?php

namespace App\Console\Commands;

use App\Models\Ledger;
use App\Models\RecurringItem;
use Illuminate\Console\Command;

class AddRecurringCharges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds recurring changes if they are schedule for that day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recurringItems = RecurringItem::where('monthly_at', now()->day)->get();

        foreach ($recurringItems as $recurringItem) {
            Ledger::create([
                'amount' => $recurringItem->amount,
                'lender_id' => $recurringItem->lender_id,
                'debtor_id' => $recurringItem->debtor_id,
                'concept' => $recurringItem->concept,
            ]);
        }

        return 0;
    }
}
