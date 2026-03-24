@extends('layouts.app')

@section('title', 'kelas')

@section('content')
<div class="class-list-container">
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    <div class="class-header">
        <h2>Daftar Kelas</h2>
        <div class="class-search">
            <input type="text" placeholder="Cari kelas...">
            <button type="button">Cari</button>
        </div>
    </div>
    <div class="class-grid">
        <div class="class-card">
            <div class="class-image">
                <img src="https://via.placeholder.com/300x150" alt="Kelas">
            </div>
            <div class="class-info">
                <h3>Pemrograman Web</h3>
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
        <div class="class-card">
            <div class="class-image">
                <img src="https://via.placeholder.com/300x150" alt="Kelas">
            </div>
            <div class="class-info">
                <h3>Basis Data</h3>
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
        <div class="class-card">
            <div class="class-image">
                <img src="https://via.placeholder.com/300x150" alt="Kelas">
            </div>
            <div class="class-info">
                <h3>Jaringan Komputer</h3>
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
@endsection
