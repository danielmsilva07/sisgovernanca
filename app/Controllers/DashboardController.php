<?php

namespace App\Controllers;

use Core\View;

class DashboardController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['authenticated'])) {
            header('Location: /login');
            exit;
        }

        View::render('dashboard', [
            'title' => 'Dashboard — SisGovernança'
        ]);
    }
}
?>