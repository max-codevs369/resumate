<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, LoginToken};
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

        Auth::login($loginToken->user);

        $loginToken->delete();

        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'));
    }
}