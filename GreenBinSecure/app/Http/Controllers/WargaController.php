<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $totalSetoran = Setoran::where('user_id', $userId)->count();
        $totalBerat = Setoran::where('user_id', $userId)->where('status', 'approved')->sum('berat');
        $pendingCount = Setoran::where('user_id', $userId)->where('status', 'pending')->count();
        $recentSetoran = Setoran::where('user_id', $userId)->latest()->take(5)->get();

        return view('warga.dashboard', compact('totalSetoran', 'totalBerat', 'pendingCount', 'recentSetoran'));
    }

    public function createSetoran()
    {
        return view('warga.setoran.create');
    }

    public function storeSetoran(Request $request)
    {
        $request->validate([
            'jenis_sampah' => 'required|string|max:100',
            'berat' => 'required|numeric|min:0.01|max:999999.99',
            'tanggal_setoran' => 'required|date|before_or_equal:today',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['jenis_sampah', 'berat', 'tanggal_setoran', 'catatan']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            $file->storeAs('public/bukti', $filename);
            $data['bukti_foto'] = 'bukti/' . $filename;

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Upload file: ' . $filename,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Setoran::create($data);

        return redirect()->route('warga.setoran.index')->with('success', 'Setoran berhasil ditambahkan.');
    }

    public function riwayatSetoran()
    {
        $setoran = Setoran::where('user_id', Auth::id())->latest()->paginate(10);
        return view('warga.setoran.index', compact('setoran'));
    }
}
