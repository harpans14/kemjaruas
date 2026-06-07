<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Akses ditolak - mencoba mengakses ' . $request->path(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
