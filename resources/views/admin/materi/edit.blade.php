@extends('layouts.app')

@section('title', 'Edit Video: ' . $materi->judul)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <a href="{{ route('admin.materi.index', $kelas->id) }}" class="text-secondary text-sm mb-1 d-block"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Playlist</a>
                    <h5 class="mb-3">Edit Materi: <span class="text-info">{{ $materi->judul }}</span></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.materi.update', ['kelas' => $kelas->id, 'materi' => $materi->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label class="form-label text-sm font-weight-bold">Judul Sesi (Contoh: Sesi 1 - Pengenalan)</label>
                                <input type="text" name="judul" class="form-control" value="{{ $materi->judul }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-sm font-weight-bold">Sesi Ke-</label>
                                <input type="number" name="urutan" class="form-control text-center font-weight-bold text-dark" value="{{ $materi->urutan }}" required>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-light border-radius-md border-start border-4 border-danger">
                            <label class="form-label text-dark font-weight-bolder"><i class="fab fa-youtube text-danger me-2"></i>Link Video YouTube</label>
                            <input type="url" name="video_url" class="form-control border-danger" value="{{ $materi->video_url }}" placeholder="https://www.youtube.com/watch?v=XXXXXXX atau format Embed" required>
                            <small class="text-xs text-secondary mt-2 d-block">Sistem akan otomatis menerjemahkan link YouTube biasa menjadi tayangan Embed (*Iframe*) yang siap dimainkan di Ruang Belajar.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm font-weight-bold">Deskripsi Ringkasan Topik / Arahan</label>
                            <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan tujuan pembelajaran dari sesi tayangan video ini...">{{ $materi->deskripsi }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.materi.index', $kelas->id) }}" class="btn btn-outline-secondary mb-0 shadow-none">Batal</a>
                            <button type="submit" class="btn bg-gradient-info mb-0">
                                <i class="fas fa-save me-2"></i>Perbarui Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
