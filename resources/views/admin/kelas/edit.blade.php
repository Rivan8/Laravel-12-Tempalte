@extends('layouts.app')

@section('title', 'Edit Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h5 class="mb-3">Informasi Kelas: <span class="text-primary">{{ $kelas->nama_kelas }}</span></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nama Kelas</label>
                                <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Spiritual Growth" {{ $kelas->kategori == 'Spiritual Growth' ? 'selected' : '' }}>Spiritual Growth</option>
                                    <option value="Leadership" {{ $kelas->kategori == 'Leadership' ? 'selected' : '' }}>Leadership</option>
                                    <option value="Volunteer" {{ $kelas->kategori == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                                    <option value="Family & Marriage" {{ $kelas->kategori == 'Family & Marriage' ? 'selected' : '' }}>Family & Marriage</option>
                                    <option value="{{ $kelas->kategori }}" {{ !in_array($kelas->kategori, ['Spiritual Growth', 'Leadership', 'Volunteer', 'Family & Marriage']) ? 'selected' : 'd-none' }}>{{ $kelas->kategori }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $kelas->deskripsi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Link Google Form Kuis (Ujian Akhir)</label>
                            <input type="url" name="link_quiz" class="form-control" value="{{ $kelas->link_quiz }}"
                                placeholder="Contoh: https://forms.gle/xxxxxx">
                            <small class="text-secondary mt-1 d-block text-xs">Biarkan kosong jika kelas ini tidak memiliki kuis ujian akhir.</small>
                        </div>

                        <div class="mb-4 bg-light p-3 border-radius-md">
                            <label class="form-label text-dark font-weight-bolder mb-2"><i class="fas fa-lock text-warning me-2"></i>Persyaratan Berantai</label>
                            <select name="prasyarat_kelas_id" class="form-select border-primary">
                                <option value="" {{ is_null($kelas->prasyarat_kelas_id) ? 'selected' : '' }}>-- Bebas Akses (Umum) --</option>
                                @foreach($kelasLain as $k)
                                    <option value="{{ $k->id }}" {{ $kelas->prasyarat_kelas_id == $k->id ? 'selected' : '' }}>Wajib Lulus Kelas: {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary mb-0 shadow-none">Kembali</a>
                            <button type="submit" class="btn bg-gradient-info mb-0">
                                <i class="fas fa-save me-2"></i>Perbarui Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
