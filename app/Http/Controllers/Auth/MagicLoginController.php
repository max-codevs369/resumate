<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, LoginToken, Resume};
use App\Notifications\MagicLinkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MagicLoginController extends Controller
{
    
    public function sendLoginLink(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            return back()->with('error', 'Akun dengan email ini telah dinonaktifkan.');
        }

        if ($user) {
            $token = LoginToken::create([
                'user_id'    => $user->id,
                'token'      => Str::random(64),
                'expires_at' => now()->addMinutes(15), 
            ]);
            $user->notify(new MagicLinkNotification($token->token));
        }


        return back()->with('success', 'Jika alamat email tersebut terdaftar di sistem kami, Anda akan segera menerima link login.');
    }

    public function verifyLogin(Request $request, $token)
    {
        $loginToken = LoginToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$loginToken) {
            return redirect()->route('login')->with('error', 'Link login tidak valid atau sudah kadaluwarsa.');
        }

        $user = $loginToken->user;

        if (!$user->is_active) {
            $loginToken->delete();
            
            return redirect()->route('login')->with('error', 'Gagal masuk. Akun Anda telah dinonaktifkan oleh Administrator.');
        }
        
        Auth::login($user);

        $loginToken->delete();

        $request->session()->regenerate();

        if (session()->has('guest_resume_id')) {
            $guestResumeId = session('guest_resume_id');
            
            $resume = Resume::where('id', $guestResumeId)->whereNull('user_id')->first();
            
            if ($resume) {
                $resume->user_id = $user->id;
                $resume->save();
            }

            session()->forget('guest_resume_id');

            return redirect()->route('user.dashboard')->with('success', 'Login berhasil! CV Anda telah disimpan ke akun ini.');
        }

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard.index'));
        }

        return redirect()->intended(route('user.dashboard'));
    }
}