@extends('layouts.app')

@section('title', 'Tambah Sesi')

@section('content')
<div class="container-fluid py-4"><div class="row justify-content-center"><div class="col-lg-8"><div class="card shadow-sm border-0"><div class="card-body">
    <a href="{{ route('admin.sesi.index', $kelas->id) }}" class="text-secondary text-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    <h5 class="mt-3">Tambah Sesi: {{ $kelas->nama_kelas }}</h5>
    <form action="{{ route('admin.sesi.store', $kelas->id) }}" method="POST">@csrf
        <div class="row">
            <div class="col-md-7 mb-3"><label class="form-label">Nama Sesi</label><input name="judul" class="form-control" placeholder="Contoh: Pengenalan Dasar" value="{{ old('judul') }}" required></div>
            <div class="col-md-2 mb-3"><label class="form-label">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', $nextUrutan) }}" min="1" required></div>
        </div>
        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea></div>
        <div class="mb-4"><label class="form-label"><i class="fas fa-link text-secondary me-1"></i>Link Quiz Eksternal (Opsional)</label><input type="url" name="link_quiz" class="form-control" placeholder="https://forms.gle/..." value="{{ old('link_quiz') }}"><small class="text-secondary">Gunakan <strong>Kelola Quiz</strong> untuk membuat quiz internal dengan pilihan ganda dan esai.</small></div>
        <div class="d-flex justify-content-end gap-2"><a href="{{ route('admin.sesi.index', $kelas->id) }}" class="btn btn-outline-secondary mb-0">Batal</a><button class="btn bg-gradient-primary mb-0"><i class="fas fa-save me-2"></i>Simpan Sesi</button></div>
    </form>
</div></div></div></div></div>
@endsection
