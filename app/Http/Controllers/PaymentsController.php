<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return Inertia::render("CreatePayment", [
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        Payment::create($request->validate([
            'amount' => 'required|integer',
            'lender_id' => 'required|exists:users,id',
            'debtor_id' => 'required|exists:users,id'
        ]));

        return redirect()->route('dashboard');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
