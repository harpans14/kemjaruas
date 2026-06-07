@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center min-vh-75 align-items-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-recycle text-success" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-2">GreenBin Secure</h4>
                    <p class="text-muted">Silakan login untuk melanjutkan</p>
                </div>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   id="username" name="username" value="{{ old('username') }}" required
                                   maxlength="50" placeholder="Masukkan username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required
                                   minlength="6" placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
                <hr class="my-4">
                <p class="text-center mb-0">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-success fw-semibold">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
