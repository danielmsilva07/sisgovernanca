<?php

namespace App\Controllers\Auth;

use App\Helpers\GoogleAuthenticator;
use App\Models\User;
use Core\View;

class TwoFactorController 
{
    private GoogleAuthenticator $gAuth;
    private User $userModel;

    public function __construct() 
    {
        $this->ensureSessionStarted();
        $this->gAuth = new GoogleAuthenticator();
        $this->userModel = new User();
    }

    // MÉTODOS DE EXIBIÇÃO DA TELA (GET /2fa)
    public function show2faForm(): void 
    {
        $this->checkPendingSession();

        $user = $this->userModel->findById($_SESSION['pending_user_id']);

        if (!$user) {
            header('Location: /login');
            exit;
        }

        // Se JÁ TEM 2FA configurado no banco -> Exibe apenas o campo de digitação
        if (!empty($user['two_factor_secret']) && !empty($user['two_factor_enabled'])) {
            View::render('auth.2fa', ['isSetup' => false], '');
            return;
        }

        // Se NÃO TEM -> Primeiro acesso: gera secret temporária e exibe QR Code
        if (empty($_SESSION['2fa_temp_secret'])) {
            $_SESSION['2fa_temp_secret'] = $this->gAuth->createSecret();
        }

        $secret = $_SESSION['2fa_temp_secret'];
        $qrCodeUrl = $this->gAuth->getQRCodeUrl('SISGOVERNANCA', $user['username'] ?? $user['email'], $secret);

        View::render('auth.2fa', [
            'isSetup'   => true,
            'qrCodeUrl' => $qrCodeUrl,
            'secret'    => $secret
        ], '');
    }

    // PROCESSAMENTO DOS FORMULÁRIOS (POST /2fa)
    public function verify2fa(): void 
    {
        $this->checkPendingSession();

        $user = $this->userModel->findById($_SESSION['pending_user_id']);
        $code = trim($_POST['code'] ?? '');

        // Caso 1: Primeiro Acesso (Gravando nova chave no banco)
        if (empty($user['two_factor_secret']) || empty($user['two_factor_enabled'])) {
            $secret = $_SESSION['2fa_temp_secret'] ?? '';

            if ($this->gAuth->verifyCode($secret, $code)) {
                $this->userModel->save2FASecret($user['id_user'], $secret);
                $this->completeLogin();
                header('Location: /dashboard');
                exit;
            }

            $qrCodeUrl = $this->gAuth->getQRCodeUrl('SISGOVERNANCA', $user['username'] ?? $user['email'], $secret);
            View::render('auth.2fa', [
                'isSetup'   => true,
                'qrCodeUrl' => $qrCodeUrl,
                'secret'    => $secret,
                'error'     => 'Código inválido. Verifique o aplicativo e tente novamente.'
            ], '');
            return;
        }

        // Caso 2: Acesso Recorrente (Validando chave já cadastrada no banco)
        if ($this->gAuth->verifyCode($user['two_factor_secret'], $code)) {
            $this->completeLogin();
            header('Location: /dashboard');
            exit;
        }

        View::render('auth.2fa', [
            'isSetup' => false,
            'error'   => 'Código de autenticação incorreto ou expirado.'
        ], '');
    }

    private function checkPendingSession(): void 
    {
        if (empty($_SESSION['pending_user_id']) || empty($_SESSION['2fa_pending'])) {
            header('Location: /login');
            exit;
        }
    }

    private function completeLogin(): void 
    {
        // Marca a sessão como autenticada para o DashboardController liberar o acesso
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id']       = $_SESSION['pending_user_id'];

        // Limpa os dados temporários da etapa de verificação 2FA
        unset($_SESSION['pending_user_id']);
        unset($_SESSION['2fa_pending']);
        unset($_SESSION['2fa_temp_secret']);
    }

    private function ensureSessionStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}