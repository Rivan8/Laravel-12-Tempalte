@extends('layouts.app')

@section('title', 'Sesi: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom">
            <div>
                <a href="{{ route('admin.kelas.index') }}" class="text-secondary text-sm d-block mb-1"><i class="fas fa-arrow-left me-1"></i>Kembali ke Kelas</a>
                <h5 class="mb-0">Kelola Sesi: <span class="text-primary">{{ $kelas->nama_kelas }}</span></h5>
            </div>
            <a href="{{ route('admin.sesi.create', $kelas->id) }}" class="btn bg-gradient-primary btn-sm mb-0"><i class="fas fa-plus me-2"></i>Tambah Sesi</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success text-white">{{ session('success') }}</div>
            @endif
            @forelse($kelas->sesis as $sesi)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <span class="badge bg-gradient-dark mb-2">Sesi {{ $sesi->urutan }}</span>
                            <h6 class="mb-1">{{ $sesi->judul }}</h6>
                            <p class="text-sm text-secondary mb-1">{{ $sesi->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                            <span class="text-xs text-secondary"><i class="fas fa-video me-1"></i>{{ $sesi->materi->count() }} video</span>
                            @if($sesi->link_quiz)
                                <span class="text-xs text-success ms-3"><i class="fas fa-clipboard-check me-1"></i>Kuis tersedia</span>
                            @elseif($sesi->quiz)
                                <span class="text-xs text-success ms-3"><i class="fas fa-clipboard-check me-1"></i>{{ $sesi->quiz->questions->count() }} soal quiz</span>
                            @else
                                <span class="text-xs text-warning ms-3"><i class="fas fa-exclamation-circle me-1"></i>Kuis belum diisi</span>
                            @endif
                            @if($sesi->materi->isNotEmpty())
                                <div class="mt-3 pt-3 border-top">
                                    <div class="text-xs text-uppercase text-secondary font-weight-bold mb-2">Video Sesi</div>
                                    @foreach($sesi->materi as $materi)
                                        <div class="d-flex justify-content-between align-items-center gap-2 py-2 border-bottom">
                                            <div class="min-width-0">
                                                <span class="text-xs text-secondary me-2">{{ $materi->urutan }}.</span>
                                                <span class="text-sm font-weight-bold">{{ $materi->judul }}</span>
                                                @if($materi->pembicara)
                                                    <span class="text-xs text-secondary ms-2">({{ $materi->pembicara }})</span>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-2 flex-shrink-0">
                                                <a href="{{ $materi->video_url }}" target="_blank" rel="noopener" class="btn btn-link text-info btn-sm mb-0 px-1" title="Buka video">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                                <a href="{{ route('admin.materi.edit', [$kelas->id, $materi->id]) }}" class="btn btn-outline-info btn-sm mb-0">
                                                    <i class="fas fa-edit me-1"></i>Edit Video
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <a href="{{ route('admin.materi.create', ['kelas' => $kelas->id, 'sesi_id' => $sesi->id]) }}" class="btn btn-outline-info btn-sm mb-0"><i class="fas fa-video me-1"></i>Tambah Video</a>
                            <a href="{{ route('admin.quiz.edit', [$kelas->id, $sesi->id]) }}" class="btn btn-outline-success btn-sm mb-0"><i class="fas fa-clipboard-check me-1"></i>Kelola Quiz</a>
                            <a href="{{ route('admin.sesi.edit', [$kelas->id, $sesi->id]) }}" class="btn btn-link text-info mb-0">Edit</a>
                            <form action="{{ route('admin.sesi.destroy', [$kelas->id, $sesi->id]) }}" method="POST" onsubmit="return confirm('Hapus sesi beserta semua videonya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-link text-danger mb-0">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-secondary">Belum ada sesi. Tambahkan sesi pertama untuk mulai mengatur video.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
