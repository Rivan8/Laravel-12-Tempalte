@extends('layouts.app')

@section('title', 'Daftar Kelas')

@push('styles')
    <link href="{{ asset('css/kelas.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="class-list-container">
        <div class="class-header">
            <h2>Daftar Kelas</h2>
            <div class="class-search">
                <input type="text" placeholder="Cari kelas...">
                <button type="button">Cari</button>
            </div>
        </div>
        <div class="class-grid">
            <!-- Contoh Class Card 1 -->
            <div class="class-card">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved0.jpg') }}" alt="Kelas">
                </div>
                <div class="class-info">
                    <h3>Pemrograman Web Lanjutan</h3>
                    <p>Dosen: Dr. John Doe</p>
                    <p>15 Mahasiswa</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                        <span>75% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- Contoh Class Card 2 -->
            <div class="class-card">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved1.jpg') }}" alt="Kelas">
                </div>
                <div class="class-info">
                    <h3>Manajemen Basis Data</h3>
                    <p>Dosen: Dr. Jane Smith</p>
                    <p>20 Mahasiswa</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <span>60% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- Contoh Class Card 3 -->
            <div class="class-card">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved6.jpg') }}" alt="Kelas">
                </div>
                <div class="class-info">
                    <h3>Jaringan Komputer & Keamanan</h3>
                    <p>Dosen: Dr. Mike Johnson</p>
                    <p>12 Mahasiswa</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%"></div>
                        </div>
                        <span>40% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>
            <div class="class-card">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved8.jpg') }}" alt="Kelas">
                </div>
                <div class="class-info">
                    <h3>Jaringan Komputer & Keamanan</h3>
                    <p>Dosen: Dr. Mike Johnson</p>
                    <p>12 Mahasiswa</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%"></div>
                        </div>
                        <span>40% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
