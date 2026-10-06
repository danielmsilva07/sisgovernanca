<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\GoogleAuthenticator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    private GoogleAuthenticator $gAuth;

    public function __construct()
    {
        $this->gAuth = new GoogleAuthenticator();
    }

    // MÉTODOS DE EXIBIÇÃO DA TELA (GET /2fa)
    public function show2faForm(Request $request)
    {
        if (!$request->session()->has('pending_user_id') || !$request->session()->has('2fa_pending')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('pending_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        // Se JÁ TEM 2FA configurado no banco -> Exibe apenas o campo de digitação
        if (!empty($user->two_factor_secret) && !empty($user->two_factor_enabled)) {
            return view('auth.2fa', ['isSetup' => false]);
        }

        // Se NÃO TEM -> Primeiro acesso: gera secret temporária na sessão e exibe QR Code
        if (!$request->session()->has('2fa_temp_secret')) {
            $request->session()->put('2fa_temp_secret', $this->gAuth->createSecret());
        }

        $secret = $request->session()->get('2fa_temp_secret');
        $qrCodeUrl = $this->gAuth->getQRCodeUrl('SISGOVERNANCA', $user->username ?? $user->email, $secret);

        return view('auth.2fa', [
            'isSetup'   => true,
            'qrCodeUrl' => $qrCodeUrl,
            'secret'    => $secret,
        ]);
    }

    // PROCESSAMENTO DOS FORMULÁRIOS (POST /2fa)
    public function verify2fa(Request $request)
    {
        if (!$request->session()->has('pending_user_id') || !$request->session()->has('2fa_pending')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('pending_user_id');
        $user = User::find($userId);
        $code = trim($request->input('code', ''));

        if (!$user) {
            return redirect()->route('login');
        }

        // Caso 1: Primeiro Acesso (Gravando nova chave no banco)
        if (empty($user->two_factor_secret) || empty($user->two_factor_enabled)) {
            $secret = $request->session()->get('2fa_temp_secret', '');

            if ($this->gAuth->verifyCode($secret, $code)) {
                // Atualiza o Model Eloquent
                $user->two_factor_secret = $secret;
                $user->two_factor_enabled = true;
                $user->save();

                $this->completeLogin($request, $user);

                return redirect()->route('dashboard');
            }

            $qrCodeUrl = $this->gAuth->getQRCodeUrl('SISGOVERNANCA', $user->username ?? $user->email, $secret);

            return view('auth.2fa', [
                'isSetup'   => true,
                'qrCodeUrl' => $qrCodeUrl,
                'secret'    => $secret,
                'error'     => 'Código inválido. Verifique o aplicativo e tente novamente.',
            ]);
        }

        // Caso 2: Acesso Recorrente (Validando chave já cadastrada no banco)
        if ($this->gAuth->verifyCode($user->two_factor_secret, $code)) {
            $this->completeLogin($request, $user);

            return redirect()->route('dashboard');
        }

        return view('auth.2fa', [
            'isSetup' => false,
            'error'   => 'Código de autenticação incorreto ou expirado.',
        ]);
    }

    private function completeLogin(Request $request, User $user): void
    {
        // Autentica o usuário na sessão nativa do Laravel
        Auth::login($user);

        // Regenera o ID da sessão para prevenir Session Fixation
        $request->session()->regenerate();

        // Limpa os dados temporários da etapa de verificação 2FA
        $request->session()->forget(['pending_user_id', '2fa_pending', '2fa_temp_secret']);
    }
}