@extends('layouts.app')

@section('title', 'Profil Member & Pencapaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Kolom Kiri: Papan Rapor Rohani -->
        <div class="col-lg-5 mb-lg-0 mb-4">
            <div class="card card-profile shadow-sm border-0 mb-4">
                <div class="card-header text-center border-0 pt-4 pt-lg-5 pb-4 pb-lg-3 bg-gradient-dark rounded-top">
                    <!-- Avatar Kosong Premium -->
                    <div class="avatar avatar-xl bg-white rounded-circle shadow-sm border border-4 border-white mb-3 mt-n5" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-graduate text-dark fa-2x"></i>
                    </div>
                </div>
                <div class="card-body pt-0 mt-n4">
                    <div class="text-center mt-3">
                        <div class="d-flex justify-content-center mb-2">
                            <span class="badge bg-gradient-success px-3 py-2 text-uppercase letter-spacing-1 shadow-sm"><i class="fas fa-chess-knight me-1"></i> {{ $user->status_user }}</span>
                        </div>
                        <h4 class="mb-1 text-dark">{{ $user->nama_lengkap }}</h4>
                        <div class="h6 font-weight-normal text-secondary mb-1">
                            <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                        </div>
                        <div class="h6 font-weight-normal text-secondary mt-2">
                            <i class="fas fa-mobile-alt me-2"></i>{{ $user->no_hp ?? 'Nomor belum dipasang' }}
                        </div>
                    </div>
                    
                    <hr class="horizontal dark my-4">
                    
                    <div class="text-center bg-light border-radius-lg p-4 shadow-inner">
                        <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 text-secondary">Fase Pertumbuhan (Logika EQUIP)</h6>
                        
                        @php
                            $equipColor = 'secondary';
                            $equipIcon = 'seedling';
                            if($user->equip_status == 'Volunteer') { $equipColor = 'primary'; $equipIcon = 'hands-helping'; }
                            elseif($user->equip_status == 'Grow') { $equipColor = 'info'; $equipIcon = 'tree'; }
                            elseif($user->equip_status == 'Plant') { $equipColor = 'success'; $equipIcon = 'leaf'; }
                        @endphp
                        
                        <span class="badge bg-gradient-{{ $equipColor }} badge-lg px-4 py-3 shadow border-radius-md mb-2" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                            <i class="fas fa-{{ $equipIcon }} me-2"></i> Fase: {{ $user->equip_status }}
                        </span>
                        
                        <p class="text-xs text-secondary mt-3 mb-0 lh-base">
                            Sistem secara otomatis mengkalkulasi pencapaian berdasarkan riwayat kelulusan modul Master Kelas Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Pengaturan Akun Bootstrap -->
        <div class="col-lg-7">
            
            @if(session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show text-white shadow-sm" role="alert">
                    <span class="alert-icon"><i class="fas fa-check"></i></span>
                    <span class="alert-text"><strong>Berhasil!</strong> Informasi profil telah diperbarui.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            
            @if(session('status') === 'password-updated')
                <div class="alert alert-info alert-dismissible fade show text-white shadow-sm" role="alert">
                    <span class="alert-icon"><i class="fas fa-shield-alt"></i></span>
                    <span class="alert-text"><strong>Aman!</strong> Kata sandi Anda telah diganti.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h6 class="mb-3 text-dark">Informasi Dasar Akun</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required autofocus autocomplete="name">
                                @error('nama_lengkap') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nomor Handphone</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" autocomplete="tel">
                                @error('no_hp') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control bg-light" value="{{ old('email', $user->email) }}" required autocomplete="username" readonly data-bs-toggle="tooltip" title="Email terikat secara paten dengan identitas Anda.">
                            @error('email') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn bg-gradient-dark mb-0 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bagian Ubah Kata Sandi -->
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h6 class="mb-1 text-dark">Ganti Kata Sandi Keamanan</h6>
                    <p class="text-xs text-secondary mb-3">Pastikan akun Anda menggunakan kombinasi sandi acak yang panjang demi ketahanan maksimal.</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" autocomplete="current-password">
                            @error('current_password', 'updatePassword') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Sandi Baru</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password">
                                @error('password', 'updatePassword') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Konfirmasi Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn bg-gradient-primary mb-0 shadow-sm"><i class="fas fa-key me-2"></i>Perbarui Sandi</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
