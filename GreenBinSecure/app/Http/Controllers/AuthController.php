<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && $user->isAccountLocked()) {
            $remainingMinutes = now()->diffInMinutes($user->lock_until);
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Login gagal - akun terkunci',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            throw ValidationException::withMessages([
                'username' => "Akun Anda terkunci. Silakan coba lagi dalam {$remainingMinutes} menit.",
            ]);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $user->update([
                'failed_login_attempts' => 0,
                'account_locked' => false,
                'lock_until' => null,
            ]);

            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Login berhasil',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $request->session()->regenerate();

            return $this->redirectToDashboard();
        }

        if ($user) {
            $user->increment('failed_login_attempts');

            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Login gagal',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($user->failed_login_attempts >= 5) {
                $user->update([
                    'account_locked' => true,
                    'lock_until' => now()->addMinutes(5),
                ]);

                ActivityLog::create([
                    'user_id' => $user->id,
                    'activity' => 'Akun terkunci karena 5 kali gagal login',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                throw ValidationException::withMessages([
                    'username' => 'Akun Anda terkunci karena terlalu banyak percobaan login gagal. Silakan coba lagi dalam 5 menit.',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'username' => 'required|string|min:4|max:50|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'warga',
        ]);

        Auth::login($user);

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Register akun',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('warga.dashboard');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'warga' => redirect()->route('warga.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
