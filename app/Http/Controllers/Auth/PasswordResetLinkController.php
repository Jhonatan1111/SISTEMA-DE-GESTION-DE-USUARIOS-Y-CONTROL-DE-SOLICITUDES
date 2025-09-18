<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //validacion de campos
        $request->validate([
            // 'token' => ['required'],
            'email' => ['required', 'email'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

            $status = Password::sendResetLink(
            $request->only('email')
        );
        // CAPTURANDO LOGS DE SOLICITUD DE RESTABLECIMIENTO DE CONTRASEÑA
        if ($status === Password::RESET_LINK_SENT) {
            \Log::info('Password reset email sent', [
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'user_agent' => $request->userAgent()
            ]);
        } else {
            \Log::warning('Failed password reset attempt', [
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'user_agent' => $request->userAgent()
            ]);
        }
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
