<?php

use App\Http\Controllers\LedgerController;
use App\Http\Controllers\RecurringController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
    Route::get('/ledger/create', [LedgerController::class, 'create'])->name('ledger.create');
    Route::post('/ledger', [LedgerController::class, 'store'])->name('ledger.store');
    Route::get('/ledger/{ledger}/edit', [LedgerController::class, 'edit'])->name('ledger.edit');
    Route::patch('/ledger/{ledger}', [LedgerController::class, 'update'])->name('ledger.update');

    Route::get('/recurring', [RecurringController::class, 'index'])->name('recurring.index');
    Route::get('/recurring/create', [RecurringController::class, 'create'])->name('recurring.create');
    Route::post('/recurring', [RecurringController::class, 'store'])->name('recurring.store');
    Route::get('/recurring/{recurringItem}/edit', [RecurringController::class, 'edit'])->name('recurring.edit');
    Route::patch('/recurring/{recurringItem}', [RecurringController::class, 'update'])->name('recurring.update');
    Route::get('/recurring/{recurringItem}', [RecurringController::class, 'destroy'])->name('recurring.delete');
});


require __DIR__.'/auth.php';
