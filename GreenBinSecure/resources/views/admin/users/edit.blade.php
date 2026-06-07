@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-pencil"></i> Edit User: {{ $user->nama }}</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3"><label for="nama" class="form-label">Nama Lengkap</label><input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required maxlength="100">@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="100">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="username" class="form-label">Username</label><input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required minlength="4" maxlength="50">@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="password" class="form-label">Password (biarkan kosong jika tidak diubah)</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" minlength="8">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="admin" {{ (old('role', $user->role) === 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ (old('role', $user->role) === 'petugas') ? 'selected' : '' }}>Petugas</option>
                            <option value="warga" {{ (old('role', $user->role) === 'warga') ? 'selected' : '' }}>Warga</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
