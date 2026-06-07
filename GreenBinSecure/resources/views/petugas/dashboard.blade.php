@extends('layouts.sidebar', ['role' => 'petugas'])

@section('title', 'Dashboard Petugas')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted mb-1">Total Setoran</h6><h3 class="fw-bold mb-0">{{ $totalSetoran }}</h3></div>
                    <div class="icon"><i class="bi bi-box-seam text-primary"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted mb-1">Pending</h6><h3 class="fw-bold mb-0">{{ $pendingCount }}</h3></div>
                    <div class="icon"><i class="bi bi-clock text-warning"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted mb-1">Approved</h6><h3 class="fw-bold mb-0">{{ $approvedCount }}</h3></div>
                    <div class="icon"><i class="bi bi-check-circle text-success"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-danger bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted mb-1">Rejected</h6><h3 class="fw-bold mb-0">{{ $rejectedCount }}</h3></div>
                    <div class="icon"><i class="bi bi-x-circle text-danger"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Setoran Terbaru</h5>
        <a href="{{ route('petugas.setoran.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-list-check"></i> Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Warga</th><th>Jenis</th><th>Berat</th><th>Tanggal</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($recentSetoran as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->jenis_sampah }}</td>
                            <td>{{ number_format($item->berat, 2) }} kg</td>
                            <td>{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                            <td>
                                @if ($item->status === 'approved') <span class="badge bg-success">Approved</span>
                                @elseif ($item->status === 'rejected') <span class="badge bg-danger">Rejected</span>
                                @else <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size: 2rem;"></i><p class="mt-2">Belum ada setoran.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
