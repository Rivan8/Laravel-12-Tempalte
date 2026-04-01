@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $pendingKelas = $myClasses->where('pivot.status', 'requested');
@endphp

{{-- Toast Notifikasi Request Kelas Pending (untuk user biasa) --}}
@if(auth()->user()->role !== 'Admin' && $pendingKelas->count() > 0)
<div style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; max-width: 340px;" id="pendingRequestToast">
    <div style="
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        overflow: hidden;
        animation: slideInToast 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        border: 1px solid rgba(0,0,0,0.06);
    ">
        <div style="
            background: linear-gradient(310deg, #f7931e 0%, #f05f2e 100%);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        ">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="
                    width: 28px; height: 28px; border-radius: 8px;
                    background: rgba(255,255,255,0.25);
                    display: flex; align-items: center; justify-content: center;
                ">
                    <i class="fas fa-bell" style="color: #fff; font-size: 0.8rem;"></i>
                </div>
                <span style="color: #fff; font-weight: 700; font-size: 0.85rem;">Menunggu Konfirmasi</span>
            </div>
            <button onclick="document.getElementById('pendingRequestToast').remove()" style="
                background: none; border: none; color: rgba(255,255,255,0.8);
                cursor: pointer; padding: 4px; line-height: 1;
                font-size: 1rem;
            ">&times;</button>
        </div>
        <div style="padding: 14px 16px;">
            <p style="font-size: 0.78rem; color: #6c757d; margin-bottom: 10px;">
                <strong style="color: #344767;">{{ $pendingKelas->count() }} kelas</strong> yang Anda daftarkan sedang menunggu persetujuan admin.
            </p>
            <div style="display: flex; flex-direction: column; gap: 6px;">
                @foreach($pendingKelas->take(3) as $pk)
                <div style="
                    display: flex; align-items: center; gap: 8px;
                    padding: 6px 10px;
                    background: #f8f9fa;
                    border-radius: 8px;
                    border-left: 3px solid #f7931e;
                ">
                    <i class="fas fa-graduation-cap" style="color: #f7931e; font-size: 0.7rem;"></i>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #344767;">{{ $pk->nama_kelas }}</span>
                </div>
                @endforeach
                @if($pendingKelas->count() > 3)
                <p style="font-size: 0.72rem; color: #adb5bd; margin: 2px 0 0; text-align: center;">
                    +{{ $pendingKelas->count() - 3 }} kelas lainnya...
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideInToast {
    0%   { opacity: 0; transform: translateY(30px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
</style>

<script>
// Auto-dismiss toast setelah 7 detik
setTimeout(function() {
    var toast = document.getElementById('pendingRequestToast');
    if (toast) {
        toast.style.transition = 'all 0.4s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(function() { toast.remove(); }, 400);
    }
}, 7000);
</script>
@endif

<div class="container-fluid py-4">
    <!-- Hero / Welcome -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card bg-gradient-primary shadow-lg">
                <div class="card-body p-5 position-relative overflow-hidden">
                    <img src="{{ asset('img/shapes/waves-white.svg') }}" alt="pattern-lines" class="position-absolute top-0 start-0 w-100 opacity-6">
                    <div class="row position-relative z-index-1">
                        <div class="col-md-8 d-flex flex-column justify-content-center text-white">
                            <h2 class="text-white mb-2 font-weight-bolder">Halo, {{ $user->nama_lengkap }}! 👋</h2>
                            <p class="mb-4 text-white opacity-8">
                                Siap untuk melanjutkan perjalanan pertumbuhan rohani Anda hari ini? Mari kita pelajari firman Tuhan secara terstruktur.
                            </p>
                            <div>
                                <a href="{{ route('kelas.index') }}" class="btn bg-white text-primary mb-0 shadow-sm font-weight-bolder">
                                    <i class="fas fa-book-reader me-2"></i> Jelajahi Katalog Kelas
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center">
                            @if(file_exists(public_path('img/illustrations/rocket-white.png')))
                                <img src="{{ asset('img/illustrations/rocket-white.png') }}" alt="illustration" class="img-fluid w-75">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Kelas</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $myClasses->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-books text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Kelas Selesai</p>
                                <h5 class="font-weight-bolder text-success mb-0">
                                    {{ $myClasses->where('pivot.status', 'completed')->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-check text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Kelas Aktif / Pending</p>
                                <h5 class="font-weight-bolder text-warning mb-0">
                                    {{ $myClasses->whereIn('pivot.status', ['in_progress', 'requested'])->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Classes -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-1">Kelas Saya</h6>
                    <p class="text-sm">Lanjutkan sesi pembelajaran Anda.</p>
                </div>
                <div class="card-body p-3">
                    @if($myClasses->isEmpty())
                        <div class="row">
                            <div class="col-md-12 text-center py-5">
                                <div class="icon icon-shape bg-gradient-secondary shadow text-center border-radius-md mb-3 mx-auto" style="width: 60px; height: 60px;">
                                    <i class="fas fa-folder-open text-white text-lg opacity-10 mt-3" aria-hidden="true"></i>
                                </div>
                                <h5 class="mt-3">Anda belum mengambil kelas apapun.</h5>
                                <p class="text-sm text-secondary">Katalog kelas kami berisi banyak materi luar biasa untuk pertumbuhan rohani Anda. Yuk mulai sekarang!</p>
                                <a href="{{ route('kelas.index') }}" class="btn bg-gradient-primary mt-3">
                                    Jelajahi Kelas Berjenjang
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach($myClasses as $kelas)
                                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                    <div class="card card-blog card-plain">
                                        <div class="position-relative" style="height: 180px; overflow: hidden;">
                                            <a class="d-block shadow-xl border-radius-xl h-100">
                                                @if($kelas->gambar)
                                                    <img src="{{ asset($kelas->gambar) }}" alt="{{ $kelas->nama_kelas }}" class="img-fluid shadow border-radius-xl" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <!-- Fallback image/gradient -->
                                                    <div class="w-100 h-100 bg-gradient-info border-radius-xl"></div>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="card-body px-1 pb-0 mt-3">
                                            <p class="text-gradient text-primary mb-2 text-xs font-weight-bold opacity-8 text-uppercase tracking-wider">{{ $kelas->kategori }}</p>
                                            <a href="javascript:;">
                                                <h5>
                                                    {{ $kelas->nama_kelas }}
                                                </h5>
                                            </a>
                                            <p class="mb-4 text-sm text-secondary" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $kelas->deskripsi }}
                                            </p>
                                            <!-- Bar Progress Terintegrasi Database -->
                                            @php 
                                                $progressDashboard = $user->classProgress($kelas->id);
                                                $barColor = $progressDashboard == 100 ? 'bg-gradient-success' : 'bg-gradient-primary';
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between mb-1 mt-3">
                                                <span class="text-xs font-weight-bold text-secondary text-uppercase tracking-wider">Kemajuan</span>
                                                <span class="text-xs font-weight-bold {{ $progressDashboard == 100 ? 'text-success' : 'text-primary' }}">{{ $progressDashboard }}%</span>
                                            </div>
                                            <div class="progress w-100 mb-4 bg-light" style="height: 6px;">
                                                <div class="progress-bar {{ $barColor }} border-radius-sm" role="progressbar" aria-valuenow="{{ $progressDashboard }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progressDashboard }}%;"></div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between">
                                                @if($kelas->pivot->status === 'completed')
                                                    <button type="button" class="btn btn-outline-success btn-sm mb-0 w-100 disabled">Selesai</button>
                                                @elseif($kelas->pivot->status === 'in_progress')
                                                    <a href="{{ route('kelas.belajar', $kelas->id) }}" class="btn bg-gradient-primary btn-sm mb-0 w-100">Lanjutkan</a>
                                                @else
                                                    <button type="button" class="btn btn-outline-warning btn-sm mb-0 w-100 disabled">Menunggu Admin</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
