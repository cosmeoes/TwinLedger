<?php

use App\Http\Controllers\LedgerController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
    Route::get('/ledger/create', [LedgerController::class, 'create'])->name('ledger.create');
    Route::post('/ledger', [LedgerController::class, 'store'])->name('ledger.store');
    Route::get('/ledger/{ledger}/edit', [LedgerController::class, 'edit'])->name('ledger.edit');
    Route::patch('/ledger/{ledger}', [LedgerController::class, 'update'])->name('ledger.update');
});


require __DIR__.'/auth.php';
