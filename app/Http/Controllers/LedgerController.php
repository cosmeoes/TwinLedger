<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LedgerController extends Controller
{
    public function index()
    {
        return Inertia::render('Ledger', [
            'ledger' => Ledger::query()
                ->with('lender:id,name')
                ->with('debtor:id,name')
                ->latest()
                ->paginate(15)
        ]);
    }

    public function create()
    {
        return Inertia::render("WriteOnLedger", [
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        Ledger::create($request->validate([
            'amount' => 'required|integer',
            'lender_id' => 'required|exists:users,id',
            'debtor_id' => 'required|exists:users,id',
            'concept' => 'required|string',
        ]));

        return redirect()->route('ledger.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Ledger $ledger)
    {
        return Inertia::render('EditLedger', [
            'users' => User::all(),
            'ledger' => $ledger
        ]);
    }

    public function update(Request $request, Ledger $ledger)
    {
        $ledger->update($request->validate([
            'amount' => 'required|integer',
            'lender_id' => 'required|exists:users,id',
            'debtor_id' => 'required|exists:users,id',
            'concept' => 'required|string',
        ]));

        return redirect()->route('ledger.index');
    }

    public function destroy($id)
    {
        //
    }
}
