<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Preencha todos os campos.',
            'password.required' => 'Preencha todos os campos.',
        ]);

        $user = User::where('username', $request->username)->first();

        // Verifica a senha (usando a coluna password_hash do seu banco)
        if ($user && Hash::check($request->password, $user->password_hash)) {
            
            // Regenera o ID da sessão para evitar Fixação de Sessão e manter os dados seguros
            $request->session()->regenerate();

            // Armazena os dados de 2FA na sessão nativa do Laravel
            session([
                'pending_user_id' => $user->id_user ?? $user->id,
                '2fa_pending' => true,
            ]);

            return redirect()->intended('/2fa');
        }

        return back()->withErrors([
            'error' => 'As credenciais fornecidas não são válidas.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}