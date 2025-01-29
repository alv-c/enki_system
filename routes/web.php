<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\CampanhaController;
use App\Http\Controllers\CampanhaPlanoPromocaoController;
use App\Http\Controllers\RifaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sistema', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/sistema/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->prefix('sistema')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('campanhas', CampanhaController::class);
    Route::resource('campanhas.planos', CampanhaPlanoPromocaoController::class)->shallow();
    Route::resource('campanhas.rifas', RifaController::class)->shallow();
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/aprovacao-usuarios', [UserApprovalController::class, 'index'])->name('admin.user-approvals.index');
    Route::post('/admin/aprovacao-usuarios/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.user-approvals.approve');
});

require __DIR__ . '/auth.php';
