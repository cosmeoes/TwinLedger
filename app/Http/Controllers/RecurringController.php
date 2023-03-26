<?php

namespace App\Http\Controllers;

use App\Models\RecurringItem;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RecurringController extends Controller
{
    public function index()
    {
        return Inertia::render('Recurring', [
            'recurringItems' => RecurringItem::query()
                ->with('lender:id,name')
                ->with('debtor:id,name')
                ->latest()
                ->paginate(15)
        ]);
    }

    public function create()
    {
        return Inertia::render("CreateRecurring", [
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        RecurringItem::create($request->validate([
            'amount' => 'required|integer',
            'lender_id' => 'required|exists:users,id',
            'debtor_id' => 'required|exists:users,id',
            'concept' => 'required|string',
            'monthly_at' => 'required|integer',
        ]));

        return redirect()->route('recurring.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(RecurringItem $recurringItem)
    {
        return Inertia::render('EditRecurring', [
            'users' => User::all(),
            'recurringItem' => $recurringItem,
        ]);
    }

    public function update(Request $request, RecurringItem $recurringItem)
    {
        $recurringItem->update($request->validate([
            'amount' => 'required|integer',
            'lender_id' => 'required|exists:users,id',
            'debtor_id' => 'required|exists:users,id',
            'monthly_at' => 'required|integer',
        ]));

        return redirect()->route('recurring.index');
    }

    public function destroy(RecurringItem $recurringItem)
    {
        $recurringItem->delete();
        return redirect()->route('recurring.index');
    }
}
