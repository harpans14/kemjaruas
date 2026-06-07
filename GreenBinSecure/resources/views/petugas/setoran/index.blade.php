@extends('layouts.sidebar', ['role' => 'petugas'])

@section('title', 'Semua Setoran')

@section('content')
<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-list-check"></i> Semua Setoran</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Warga</th><th>Jenis Sampah</th><th>Berat (kg)</th><th>Tanggal</th><th>Status</th><th>Foto</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($setoran as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->jenis_sampah }}</td>
                            <td>{{ number_format($item->berat, 2) }}</td>
                            <td>{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                            <td>
                                @if ($item->status === 'approved') <span class="badge bg-success">Approved</span>
                                @elseif ($item->status === 'rejected') <span class="badge bg-danger">Rejected</span>
                                @else <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->bukti_foto)
                                    <a href="{{ Storage::url($item->bukti_foto) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-image"></i></a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status === 'pending')
                                    <div class="d-flex gap-1">
                                        <form action="{{ route('petugas.setoran.approve', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve setoran ini?')"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                        <form action="{{ route('petugas.setoran.reject', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject setoran ini?')"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size: 2rem;"></i><p class="mt-2">Belum ada setoran.</p></td></tr>
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
