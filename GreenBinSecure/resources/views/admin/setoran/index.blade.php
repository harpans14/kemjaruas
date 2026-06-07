@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Semua Setoran')

@section('content')
<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-box-seam"></i> Semua Setoran</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Warga</th><th>Jenis Sampah</th><th>Berat (kg)</th><th>Tanggal</th><th>Status</th><th>Foto</th><th>Dibuat</th></tr>
                </thead>
                <tbody>
                    @forelse ($setoran as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->jenis_sampah }}</td>
                            <td>{{ number_format($item->berat, 2) }}</td>
                            <td>{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                            <td><span class="badge bg-{{ $item->status === 'approved' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning text-dark') }}">{{ ucfirst($item->status) }}</span></td>
                            <td>
                                @if ($item->bukti_foto)
                                    <a href="{{ Storage::url($item->bukti_foto) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-image"></i></a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada setoran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($setoran->hasPages())
        <div class="card-footer bg-white">{{ $setoran->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
