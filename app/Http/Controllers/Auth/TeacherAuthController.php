<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class TeacherAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.teacher-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $seconds detik.",
            ])->onlyInput('email');
        }

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && in_array($user->role, ['teacher', 'admin', 'dosen'])) {
            if (Auth::attempt($credentials)) {
                RateLimiter::clear($throttleKey);
                $request->session()->regenerate();
                return redirect()->intended(route('teacher.dashboard'));
            }
        }

        RateLimiter::hit($throttleKey);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('teacher.login');
    }
}
