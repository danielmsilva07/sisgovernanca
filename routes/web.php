<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AltoNivel\AgendaController;
use App\Http\Controllers\AltoNivel\OrdemCmController;
use App\Http\Controllers\ControleInterno\ControleInternoController;
use App\Http\Controllers\Integridade\IntegridadeController;
use App\Http\Controllers\UserController;

// Autenticação e Acesso
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/2fa', [TwoFactorController::class, 'show2faForm']);
Route::post('/2fa', [TwoFactorController::class, 'verify2fa']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Painel Principal
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rotas do Módulo: Assuntos de Alto Nível - Agenda
Route::prefix('alto-nivel/agenda')->group(function () {
    Route::get('/', [AgendaController::class, 'index'])->name('alto-nivel.agenda');
    Route::post('/salvar', [AgendaController::class, 'storeAgenda']);
    Route::post('/evento/salvar', [AgendaController::class, 'storeEvento']);
    Route::post('/evento/atualizar', [AgendaController::class, 'atualizarEvento']);
    Route::get('/evento/historico', [AgendaController::class, 'obterHistorico']);
});
Route::get('/assuntos-alto-nivel', [AgendaController::class, 'index']);
Route::get('/alto-nivel/deliberacoes', [AgendaController::class, 'index'])->name('alto-nivel.deliberacoes');

// Rotas do Módulo: Assuntos de Alto Nível - Ordens do CM
Route::prefix('alto-nivel/ordens-cm')->group(function () {
    Route::get('/', [OrdemCmController::class, 'index'])->name('alto-nivel.ordens-cm');
    Route::get('/novo', [OrdemCmController::class, 'create'])->name('alto-nivel.ordens-cm.novo');
    Route::post('/salvar', [OrdemCmController::class, 'store'])->name('alto-nivel.ordens-cm.store');
});

// Rotas do Módulo: Controle Interno
Route::prefix('controle-interno')->group(function () {
    Route::get('/', [ControleInternoController::class, 'index']);
});

// Rotas do Módulo: Integridade
Route::prefix('integridade')->group(function () {
    Route::get('/', [IntegridadeController::class, 'index']);
});

// Administrativo (Manutenção de Usuários)
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/novo', [UserController::class, 'create']);
    Route::post('/salvar', [UserController::class, 'store']);
});

Route::get('/relatorios/gestao', function () {
    return view('relatorios.gestao');
    })->name('relatorios.gestao');