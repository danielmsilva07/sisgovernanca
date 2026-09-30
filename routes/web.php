<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\TwoFactorController;
use App\Controllers\DashboardController;
use App\Controllers\AltoNivel\AgendaController; // Submódulo do Alto Nível - Agenda
use App\Controllers\AltoNivel\OrdemCmController; // Submódulo do Alto Nível - Ordens do CM
use App\Controllers\ControleInternoController;
use App\Controllers\IntegridadeController;
use App\Controllers\UserController;

// Autenticação e Acesso
$router->get('/login', [LoginController::class, 'showLoginForm']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/2fa', [TwoFactorController::class, 'show2faForm']);
$router->post('/2fa', [TwoFactorController::class, 'verify2fa']);
$router->get('/logout', [LoginController::class, 'logout']);

// Painel Principal
$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);

// Rotas do Módulo: Assuntos de Alto Nível - Agenda
$router->get('/assuntos-alto-nivel', [AgendaController::class, 'index']);
$router->get('/alto-nivel/agenda', [AgendaController::class, 'index']);
$router->post('/alto-nivel/agenda/salvar', [AgendaController::class, 'storeAgenda']);
$router->post('/alto-nivel/agenda/evento/salvar', [AgendaController::class, 'storeEvento']);
$router->post('/alto-nivel/agenda/evento/atualizar', [AgendaController::class, 'atualizarEvento']);
$router->get('/alto-nivel/agenda/evento/historico', [AgendaController::class, 'obterHistorico']); // Rota da API do Histórico

// Rotas do Módulo: Assuntos de Alto Nível - Ordens do CM
$router->get('/alto-nivel/ordens-cm', [OrdemCmController::class, 'index']);
$router->get('/alto-nivel/ordens-cm/novo', [OrdemCmController::class, 'create']);
$router->post('/alto-nivel/ordens-cm/salvar', [OrdemCmController::class, 'store']);

// Demais Módulos do Sistema
$router->get('/controle-interno', [ControleInternoController::class, 'index']);
$router->get('/integridade', [IntegridadeController::class, 'index']);

// Administrativo (Manutenção de Usuários)
$router->get('/usuarios', [UserController::class, 'index']);
$router->get('/usuarios/novo', [UserController::class, 'create']);
$router->post('/usuarios/salvar', [UserController::class, 'store']);
?>