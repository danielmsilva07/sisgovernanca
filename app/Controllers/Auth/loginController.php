<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Core\View;

class LoginController
{
    public function showLoginForm(): void
    {
        View::render('auth.login', [], '');
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            View::render('auth.login', ['error' => 'Preencha todos os campos.'], '');
            return;
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        // Corrigido 'f' para 'if'
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['pending_user_id'] = $user['id_user'];
            $_SESSION['2fa_pending'] = true;
        
            header('Location: /2fa');
            exit;
        }

        View::render('auth.login', ['error' => 'As credenciais fornecidas não são válidas.'], '');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>