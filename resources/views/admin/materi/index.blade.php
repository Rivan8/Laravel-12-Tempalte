@extends('layouts.app')

@section('title', 'Materi Video: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="fas fa-check"></i></span>
                <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-transparent border-bottom mb-3">
                    <div>
                        <a href="{{ route('admin.kelas.index') }}" class="text-secondary text-sm mb-1 d-block"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Kelas</a>
                        <h5 class="mb-0">Kelola Video Sesi: <span class="text-primary">{{ $kelas->nama_kelas }}</span></h5>
                    </div>
                    <a href="{{ route('admin.materi.create', $kelas->id) }}" class="btn bg-gradient-info btn-sm mb-0">
                        <i class="fas fa-video me-2"></i>Tambah Video Sesi
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="text-uppercase font-weight-bolder opacity-7 px-4" style="width: 10%">Urutan</th>
                                    <th class="text-uppercase font-weight-bolder opacity-7 ps-2" style="width: 40%">Judul & Deskripsi Sesi</th>
                                    <th class="text-center text-uppercase font-weight-bolder opacity-7" style="width: 30%">Video URL</th>
                                    <th class="text-center text-uppercase font-weight-bolder opacity-7" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas->materi as $m)
                                <tr class="border-bottom">
                                    <td class="px-4 text-center">
                                        <span class="badge bg-dark badge-sm px-3 py-2 fs-6">Sesi {{ $m->urutan }}</span>
                                    </td>
                                    <td>
                                        <h6 class="mb-1 text-dark font-weight-bold">{{ $m->judul }}</h6>
                                        <p class="text-xs text-secondary mb-0 w-75">{{ Str::limit($m->deskripsi, 80) }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ $m->video_url }}" target="_blank" class="text-sm text-info text-decoration-underline" data-bs-toggle="tooltip" title="Uji Coba Tonton">
                                            <i class="fab fa-youtube text-danger me-1"></i> Tonton Cuplikan
                                        </a>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('admin.materi.edit', ['kelas' => $kelas->id, 'materi' => $m->id]) }}" class="btn btn-link text-info text-gradient px-2 mb-0 shadow-none">
                                                <i class="fas fa-edit me-2" aria-hidden="true"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.materi.destroy', ['kelas' => $kelas->id, 'materi' => $m->id]) }}" method="POST" onsubmit="return confirm('Hapus video sesi ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-2 mb-0 shadow-none">
                                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-video-slash fa-3x text-secondary mb-3 opacity-4"></i>
                                            <h6 class="text-secondary font-weight-normal">Belum ada tayangan video yang diunggah untuk kelas ini.</h6>
                                            <a href="{{ route('admin.materi.create', $kelas->id) }}" class="btn btn-outline-primary btn-sm mt-3">Mulai Unggah Sesi Pertama</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
