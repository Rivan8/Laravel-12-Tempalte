@extends('layouts.app')

@section('title', 'Detail Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <a href="javascript:;" class="d-block">
                        @if($kelas->gambar)
                            <img src="{{ asset($kelas->gambar) }}" class="img-fluid border-radius-lg shadow">
                        @else
                            <div class="w-100 bg-gradient-dark border-radius-lg d-flex align-items-center justify-content-center" style="height: 350px;">
                                <i class="fas fa-chalkboard-teacher text-white opacity-4" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </a>
                </div>
                <div class="card-body pt-4">
                    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{ $kelas->kategori }}</span>
                    <h3 class="font-weight-bolder mb-3">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-secondary mb-4">
                        {{ $kelas->deskripsi }}
                    </p>
                    
                    <h5 class="mt-5 mb-3">Apa yang akan Anda pelajari?</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item border-0 ps-0 text-sm"><i class="fas fa-check text-success me-2"></i> Pengenalan dasar yang komprehensif.</li>
                        <li class="list-group-item border-0 ps-0 text-sm"><i class="fas fa-check text-success me-2"></i> Fondasi kerohanian yang mengakar.</li>
                        <li class="list-group-item border-0 ps-0 text-sm"><i class="fas fa-check text-success me-2"></i> Langkah-langkah praktikal kehidupan rohani.</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Detail -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body p-4 text-center">
                    <h5 class="mb-3">Mulai Perjalanan Anda</h5>
                    <p class="text-sm text-secondary mb-4">Daftarkan diri Anda pada kelas ini untuk mengakses seluruh materi video dan bahan ajarnya.</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success text-white text-sm" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger text-white text-sm" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if(!$status)
                        <form action="{{ route('kelas.request', $kelas->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mb-0 shadow-lg">
                                <i class="fas fa-paper-plane me-2"></i> Request Kelas Ini
                            </button>
                        </form>
                    @elseif($status === 'requested')
                        <div class="alert alert-warning text-white font-weight-bold" role="alert">
                            <i class="fas fa-clock me-2"></i> Menunggu Persetujuan Admin
                        </div>
                        <button class="btn btn-outline-secondary w-100 disabled mb-0">Request Terkirim</button>
                    @elseif($status === 'in_progress' || $status === 'completed')
                        <div class="alert alert-success text-white font-weight-bold" role="alert">
                            <i class="fas fa-check-circle me-2"></i> Anda Sudah Terdaftar
                        </div>
                        <a href="{{ route('kelas.belajar', $kelas->id) }}" class="btn bg-gradient-info btn-lg w-100 mb-0 shadow">
                            <i class="fas fa-play me-2"></i> Lanjutkan Belajar
                        </a>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-top text-center pt-3 pb-3">
                    <a href="{{ route('kelas.index') }}" class="text-sm text-primary font-weight-bold">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog
                    </a>
                </div>
            </div>

            {{-- ── MATERI PENDUKUNG (DOWNLOAD) ── --}}
            <div class="card shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="mb-3">
                        <i class="fas fa-file-download text-primary me-2"></i>Materi Pendukung
                    </h6>
                    
                    @if($kelas->handbook)
                    <a href="{{ asset($kelas->handbook) }}" class="btn btn-outline-primary btn-sm w-100 mb-2" download>
                        <i class="fas fa-file-pdf me-2"></i> Download Handbook
                    </a>
                    @endif
                    
                    @if($kelas->tools)
                    <a href="{{ asset($kelas->tools) }}" class="btn btn-outline-primary btn-sm w-100 mb-2" download>
                        <i class="fas fa-tools me-2"></i> Download Tools
                    </a>
                    @endif
                    
                    @if($kelas->slide)
                    <a href="{{ asset($kelas->slide) }}" class="btn btn-outline-primary btn-sm w-100 mb-0" download>
                        <i class="fas fa-file-powerpoint me-2"></i> Download Slide
                    </a>
                    @endif

                    @if(!$kelas->handbook && !$kelas->tools && !$kelas->slide)
                    <p class="text-xs text-secondary mb-0 mt-2">
                        <i class="fas fa-info-circle me-1"></i> Data file masih kosong di database.
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
