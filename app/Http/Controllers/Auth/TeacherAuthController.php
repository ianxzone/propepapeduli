<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\ActivityLog;


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
            'captcha' => ['required', 'captcha'],
        ], [
            'captcha.captcha' => 'Kode captcha tidak valid.',
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
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'teacher_login_success',
                    'module' => 'Authentication',
                    'details' => json_encode(['role' => $user->role]),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                RateLimiter::clear($throttleKey);
                $request->session()->regenerate();
                return redirect()->intended(route('teacher.dashboard'));
            }
        }

        RateLimiter::hit($throttleKey);

        ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'action' => 'teacher_login_failed',
            'module' => 'Authentication',
            'details' => json_encode(['email' => $credentials['email']]),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'teacher_logout',
                'module' => 'Authentication',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('teacher.login');
    }
}
