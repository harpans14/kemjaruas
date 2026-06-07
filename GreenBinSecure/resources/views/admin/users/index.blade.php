@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Kelola User')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-people"></i> Data User</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm"><i class="bi bi-person-plus"></i> Tambah User</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama</th><th>Email</th><th>Username</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'petugas' ? 'secondary' : 'info') }}">{{ ucfirst($user->role) }}</span></td>
                            <td>
                                @if ($user->account_locked)
                                    <span class="badge bg-danger">Terkunci</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data user.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($users->hasPages())
        <div class="card-footer bg-white">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
