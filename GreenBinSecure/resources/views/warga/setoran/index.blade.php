@extends('layouts.sidebar', ['role' => 'warga'])

@section('title', 'Riwayat Setoran')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Setoran</h5>
        <a href="{{ route('warga.setoran.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Tambah Setoran</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Jenis Sampah</th><th>Berat (kg)</th><th>Tanggal</th><th>Status</th><th>Foto</th><th>Dibuat</th></tr>
                </thead>
                <tbody>
                    @forelse ($setoran as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->jenis_sampah }}</td>
                            <td>{{ number_format($item->berat, 2) }}</td>
                            <td>{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                            <td>
                                @if ($item->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($item->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->bukti_foto)
                                    <a href="{{ Storage::url($item->bukti_foto) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-image"></i> Lihat</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size: 2rem;"></i><p class="mt-2">Belum ada setoran.</p></td></tr>
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
