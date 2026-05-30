@extends('layouts.app')
@section('title', 'Tambah Lapangan')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.fields') }}" class="btn btn-outline-secondary rounded-circle" style="width:38px;height:38px;padding:0;line-height:36px;text-align:center;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Tambah Lapangan Baru</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lapangan <span class="text-danger">*</span></label>
                <input type="text" name="nama_lapangan" class="form-control @error('nama_lapangan') is-invalid @enderror"
                       placeholder="cth: Lapangan A" value="{{ old('nama_lapangan') }}" required>
                @error('nama_lapangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                       placeholder="cth: Gedung Utama – Lantai 1" value="{{ old('lokasi') }}" required>
                @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Harga per Jam (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="harga_per_jam" class="form-control @error('harga_per_jam') is-invalid @enderror"
                       placeholder="100000" value="{{ old('harga_per_jam') }}" min="0" required>
                @error('harga_per_jam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="tersedia" {{ old('status')=='tersedia'?'selected':'' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status')=='tidak tersedia'?'selected':'' }}>Tidak Tersedia</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"
                          placeholder="Deskripsi singkat lapangan...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Foto Lapangan</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                       accept="image/*" id="fotoInput">
                <div class="mt-2">
                    <img id="preview" src="#" alt="Preview" class="rounded d-none" style="max-height:180px;">
                </div>
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                    <i class="fas fa-save me-2"></i>Simpan Lapangan
                </button>
                <a href="{{ route('admin.fields') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const file = e.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
});
</script>
@endsection
