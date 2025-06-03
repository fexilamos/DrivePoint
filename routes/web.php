<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\PayPalController;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\ReservaController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('carros', CarroController::class);
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil');
});
Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa');
Route::get('/reservas', [PesquisaController::class, 'reservas'])
    ->middleware(['auth', 'verified'])
    ->name('reservas');
Route::get('/reservas/{id}/pdf', [App\Http\Controllers\ReservaController::class, 'pdf'])->name('reservas.pdf');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', [PayPalController::class, 'createTransaction'])->name('create');
    Route::get('/process', [PayPalController::class, 'processTransaction'])->name('process');
    Route::get('/success', [PayPalController::class, 'successTransaction'])->name('success');
    Route::get('/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancel');
    Route::get('/finish', [PayPalController::class, 'finishTransaction'])->name('finish');
});



require __DIR__.'/auth.php';
