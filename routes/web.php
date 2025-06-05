<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\PesquisaController;


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
    Route::patch('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil');
    Route::get('/transaction', [App\Http\Controllers\ReservaController::class, 'showMultibanco'])->name('transaction');
    Route::post('/transaction/confirmar', [App\Http\Controllers\ReservaController::class, 'confirmarPagamentoMultibanco'])->name('multibanco.confirmar');
    Route::get('/transaction/finish', [App\Http\Controllers\ReservaController::class, 'finishMultibanco'])->name('multibanco.finish');
    Route::get('/reservas/confirmar', [ReservaController::class, 'confirmar'])->name('reservas.confirmar');
    Route::post('/reservas/confirmar', [ReservaController::class, 'confirmar'])->name('reservas.confirmar');
    Route::get('/reservas/{id}/enviar-email', [ReservaController::class, 'enviarEmailReserva'])->name('reservas.enviarEmail');
    Route::get('/reservas/{id}', [ReservaController::class, 'show'])->name('reservas.show');
});
Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa');
Route::get('/reservas', [PesquisaController::class, 'reservas'])
    ->middleware(['auth', 'verified'])
    ->name('reservas');
Route::get('/reservas/{id}/pdf', [App\Http\Controllers\ReservaController::class, 'pdf'])->name('reservas.pdf');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');




require __DIR__.'/auth.php';
