<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Password, RateLimiter};
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $rateLimitKey = 'forgot-password:' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()
                ->withInput()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        RateLimiter::hit($rateLimitKey, 600);

        return back()->with(
            'success',
            'Jika email Anda terdaftar, link reset password akan segera dikirim. Silakan cek inbox atau folder spam.'
        );
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).+$/',
            ],
        ], [
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex'     => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['success' => true]);
        }

        $errorMessage = match ($status) {
            Password::INVALID_TOKEN => 'Link reset password tidak valid atau sudah kedaluwarsa. Silakan minta link baru.',
            Password::INVALID_USER  => 'Email tidak ditemukan di sistem kami.',
            default                 => 'Terjadi kesalahan. Silakan coba lagi.',
        };

        return response()->json([
            'success' => false,
            'message' => $errorMessage
        ], 400);
    }
}