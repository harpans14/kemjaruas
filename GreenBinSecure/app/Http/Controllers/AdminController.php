<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setoran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalWarga = User::where('role', 'warga')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalSetoran = Setoran::count();
        $pendingCount = Setoran::where('status', 'pending')->count();
        $totalBerat = Setoran::where('status', 'approved')->sum('berat');
        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalWarga', 'totalPetugas',
            'totalSetoran', 'pendingCount', 'totalBerat',
            'recentLogs'
        ));
    }

    public function usersIndex()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'username' => 'required|string|min:4|max:50|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,warga',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'username' => 'required|string|min:4|max:50|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,petugas,warga',
        ]);

        $data = $request->only(['nama', 'email', 'username', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function usersDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function setoranIndex()
    {
        $setoran = Setoran::with('user')->latest()->paginate(10);
        return view('admin.setoran.index', compact('setoran'));
    }

    public function logsIndex()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }
}
