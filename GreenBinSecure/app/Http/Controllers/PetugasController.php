<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalSetoran = Setoran::count();
        $pendingCount = Setoran::where('status', 'pending')->count();
        $approvedCount = Setoran::where('status', 'approved')->count();
        $rejectedCount = Setoran::where('status', 'rejected')->count();
        $recentSetoran = Setoran::with('user')->latest()->take(10)->get();

        return view('petugas.dashboard', compact('totalSetoran', 'pendingCount', 'approvedCount', 'rejectedCount', 'recentSetoran'));
    }

    public function indexSetoran()
    {
        $setoran = Setoran::with('user')->latest()->paginate(10);
        return view('petugas.setoran.index', compact('setoran'));
    }

    public function approve(Setoran $setoran)
    {
        if ($setoran->status !== 'pending') {
            return back()->with('error', 'Setoran sudah diproses sebelumnya.');
        }

        $setoran->update(['status' => 'approved']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Approve setoran ID: ' . $setoran->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Setoran berhasil di-approve.');
    }

    public function reject(Setoran $setoran)
    {
        if ($setoran->status !== 'pending') {
            return back()->with('error', 'Setoran sudah diproses sebelumnya.');
        }

        $setoran->update(['status' => 'rejected']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Reject setoran ID: ' . $setoran->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Setoran berhasil di-reject.');
    }
}
