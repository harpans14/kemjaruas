@extends('layouts.sidebar', ['role' => 'warga'])

@section('title', 'Tambah Setoran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Form Tambah Setoran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('warga.setoran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="jenis_sampah" class="form-label">Jenis Sampah</label>
                        <select class="form-select @error('jenis_sampah') is-invalid @enderror" id="jenis_sampah" name="jenis_sampah" required>
                            <option value="">Pilih jenis sampah</option>
                            <option value="Plastik" {{ old('jenis_sampah') === 'Plastik' ? 'selected' : '' }}>Plastik</option>
                            <option value="Kertas" {{ old('jenis_sampah') === 'Kertas' ? 'selected' : '' }}>Kertas</option>
                            <option value="Kaca" {{ old('jenis_sampah') === 'Kaca' ? 'selected' : '' }}>Kaca</option>
                            <option value="Logam" {{ old('jenis_sampah') === 'Logam' ? 'selected' : '' }}>Logam</option>
                            <option value="Organik" {{ old('jenis_sampah') === 'Organik' ? 'selected' : '' }}>Organik</option>
                            <option value="Elektronik" {{ old('jenis_sampah') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Lainnya" {{ old('jenis_sampah') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_sampah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="berat" class="form-label">Berat (kg)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0.01" max="999999.99"
                                   class="form-control @error('berat') is-invalid @enderror"
                                   id="berat" name="berat" value="{{ old('berat') }}" required placeholder="Contoh: 2.5">
                            <span class="input-group-text">kg</span>
                            @error('berat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_setoran" class="form-label">Tanggal Setoran</label>
                        <input type="date" class="form-control @error('tanggal_setoran') is-invalid @enderror"
                               id="tanggal_setoran" name="tanggal_setoran"
                               value="{{ old('tanggal_setoran', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}">
                        @error('tanggal_setoran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="bukti_foto" class="form-label">Bukti Foto</label>
                        <input type="file" class="form-control @error('bukti_foto') is-invalid @enderror"
                               id="bukti_foto" name="bukti_foto" accept=".jpg,.jpeg,.png">
                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                        @error('bukti_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (opsional)</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror"
                                  id="catatan" name="catatan" rows="3" maxlength="500">{{ old('catatan') }}</textarea>
                        @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Setoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
