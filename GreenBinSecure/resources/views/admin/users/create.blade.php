@extends('layouts.sidebar', ['role' => 'admin'])

@section('title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-person-plus"></i> Form Tambah User</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3"><label for="nama" class="form-label">Nama Lengkap</label><input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required maxlength="100">@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required maxlength="100">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="username" class="form-label">Username</label><input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required minlength="4" maxlength="50">@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required minlength="8">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="warga" {{ old('role') === 'warga' ? 'selected' : '' }}>Warga</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
