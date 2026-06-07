@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Activity Log')

@section('content')
<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-activity"></i> Activity Log</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>User</th><th>Aktivitas</th><th>IP Address</th><th>User Agent</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user ? $log->user->nama : 'System' }}</td>
                            <td>{{ $log->activity }}</td>
                            <td><code>{{ $log->ip_address }}</code></td>
                            <td class="text-truncate" style="max-width: 200px;" title="{{ $log->user_agent }}">{{ Str::limit($log->user_agent, 50) }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada log aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($logs->hasPages())
        <div class="card-footer bg-white">{{ $logs->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
