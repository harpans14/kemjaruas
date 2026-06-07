@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card stat-card bg-primary bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Total User</h6><h3 class="fw-bold mb-0">{{ $totalUsers }}</h3></div><div class="icon"><i class="bi bi-people text-primary"></i></div></div></div></div></div>
    <div class="col-md-3"><div class="card stat-card bg-info bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Warga</h6><h3 class="fw-bold mb-0">{{ $totalWarga }}</h3></div><div class="icon"><i class="bi bi-person text-info"></i></div></div></div></div></div>
    <div class="col-md-3"><div class="card stat-card bg-secondary bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Petugas</h6><h3 class="fw-bold mb-0">{{ $totalPetugas }}</h3></div><div class="icon"><i class="bi bi-person-badge text-secondary"></i></div></div></div></div></div>
    <div class="col-md-3"><div class="card stat-card bg-success bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Total Setoran</h6><h3 class="fw-bold mb-0">{{ $totalSetoran }}</h3></div><div class="icon"><i class="bi bi-box-seam text-success"></i></div></div></div></div></div>
    <div class="col-md-3"><div class="card stat-card bg-warning bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Pending</h6><h3 class="fw-bold mb-0">{{ $pendingCount }}</h3></div><div class="icon"><i class="bi bi-clock text-warning"></i></div></div></div></div></div>
    <div class="col-md-3"><div class="card stat-card bg-primary bg-opacity-10"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-1">Total Berat (kg)</h6><h3 class="fw-bold mb-0">{{ number_format($totalBerat, 2) }}</h3></div><div class="icon"><i class="bi bi-speedometer2 text-primary"></i></div></div></div></div></div>
</div>
<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-activity"></i> Aktivitas Terbaru</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>User</th><th>Aktivitas</th><th>IP Address</th><th>Waktu</th></tr></thead>
                <tbody>
                    @forelse ($recentLogs as $log)
                        <tr>
                            <td>{{ $log->user ? $log->user->nama : 'System' }}</td>
                            <td>{{ $log->activity }}</td>
                            <td><code>{{ $log->ip_address }}</code></td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
