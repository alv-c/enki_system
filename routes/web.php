<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\CampanhaController;
use App\Http\Controllers\CampanhaPlanoPromocaoController;
use App\Http\Controllers\RifaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Comprador\RifaCompraController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CheckoutController; // Ensure this class exists in the specified namespace

/**
 * ROTAS PARA COMPRADORES
 */
Route::get('/', function () {
    return view('welcome');
});

//criar outra rota para comprador com get'/', porém com middleware de autenticação para o comprador
// Route::get('/sistema', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified', 'MIDDLEWARE PARA COMPRADOR'])
//     ->name('dashboard');

Route::middleware(['auth', 'verified', 'comprador'])->prefix('comprador')->group(function () {
    // Campanhas e Rifas
    Route::get('/campanhas', [RifaCompraController::class, 'index'])->name('comprador.campanhas');
    Route::get('/campanhas/{campanha}', [RifaCompraController::class, 'show'])->name('comprador.campanha.rifas');

    // Carrinho e Checkout
    Route::get('/carrinho', [CheckoutController::class, 'index'])->name('comprador.carrinho');
    Route::post('/carrinho/adicionar/{rifa}', [CheckoutController::class, 'adicionarAoCarrinho'])->name('comprador.carrinho.adicionar');
    Route::delete('/carrinho/remover/{id}', [CheckoutController::class, 'removerDoCarrinho'])->name('comprador.carrinho.remover');
    Route::post('/checkout', [CheckoutController::class, 'finalizarCompra'])->name('comprador.checkout.processar');

    // Pedidos
    Route::get('/meus-pedidos', [PedidoController::class, 'index'])->name('comprador.meus-pedidos');
});

/**
 * RODAS ALTERAÇÃO DE PERFIL
 */
// Route::middleware(['auth', 'verified'])->prefix('comprador')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

/**
 * ROTAS PARA ADMS NIVEL 1
 */
Route::get('/sistema', [DashboardController::class, 'index'])
    ->middleware(['verified', 'auth', 'admin_role'])
    ->name('dashboard');

Route::middleware(['verified', 'auth', 'admin_role'])->prefix('sistema')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('campanhas', [CampanhaController::class, 'index'])->name('campanhas');
    Route::resource('campanhas', CampanhaController::class);
    Route::resource('campanhas.planos', CampanhaPlanoPromocaoController::class)->shallow(); //Clique para gerenciar planos de uma campanha
    // Route::resource('campanhas.rifas', RifaController::class)->shallow();
    Route::get('/campanhas/{campanha}/rifas', [RifaController::class, 'index'])->name('campanhas.rifas.index');
});


/**
 * ROTAS PARA ADMS NIVEL 2
 */
//criar outra rota para tela inicial admin, com seu controller
// Route::get('/sistema', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified', 'MIDDLEWARE PARA COMPRADOR'])
//     ->name('dashboard');

Route::middleware(['verified', 'auth', 'admin_role', 'admin'])->group(function () {
    Route::get('/admin/aprovacao-usuarios', [UserApprovalController::class, 'index'])->name('admin.user-approvals.index');
    Route::post('/admin/aprovacao-usuarios/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.user-approvals.approve');
});

require __DIR__ . '/auth.php';
