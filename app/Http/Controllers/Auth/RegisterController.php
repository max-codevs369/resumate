<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, LoginToken}; 
use App\Notifications\MagicLinkNotification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard'); 
        }

        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                    ->letters()     
                    ->mixedCase()    
                    ->numbers()      
                    ->symbols()      
            ],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.letters'   => 'Password harus mengandung huruf.',
            'password.mixed'     => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'   => 'Password harus mengandung angka.',
            'password.symbols'   => 'Password harus mengandung simbol.',   
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        $token = LoginToken::create([
            'user_id'    => $user->id,
            'token'      => Str::random(64),
            'expires_at' => now()->addHours(24), 
        ]);

        $user->notify(new MagicLinkNotification($token->token));

        return back()->with('success', 'Pendaftaran berhasil! Kami telah mengirimkan link verifikasi ke email Anda. Silakan klik link tersebut untuk mengaktifkan akun dan masuk ke Dashboard.');
    }
}