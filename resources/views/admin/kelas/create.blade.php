@extends('layouts.app')

@section('title', 'Tambah Master Kelas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h5 class="mb-3">Tambah Master Kelas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nama Kelas</label>
                                <input type="text" name="nama_kelas" class="form-control"
                                    placeholder="Contoh: Foundation Class 1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Disciples Community">Disciples Community</option>
                                    <option value="Equip - New">Equip - New</option>
                                    <option value="Equip - Plant">Equip - Plant</option>
                                    <option value="Equip - Grow">Equip - Grow</option>
                                    <option value="Equip - Fruitful">Equip - Fruitful</option>
                                    <option value="Leadership">Leadership</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="4"
                                placeholder="Tuliskan ulasan mengenai kurikulum kelas ini..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Link Google Form Kuis (Ujian Akhir)</label>
                            <input type="url" name="link_quiz" class="form-control"
                                placeholder="Contoh: https://forms.gle/xxxxxx">
                            <small class="text-secondary mt-1 d-block text-xs">Biarkan kosong jika kelas ini tidak memiliki kuis ujian akhir.</small>
                        </div>

                        <div class="mb-4 bg-light p-3 border-radius-md">
                            <label class="form-label text-dark font-weight-bolder mb-2"><i
                                    class="fas fa-lock text-warning me-2"></i>Persyaratan Keamanan Mengikuti Kelas
                                Ini</label>
                            <select name="prasyarat_kelas_id" class="form-select border-primary">
                                <option value="">-- Bebas Akses (Tidak ada syarat lulus kelas lain) --</option>
                                @foreach($kelasLain as $k)
                                <option value="{{ $k->id }}">Wajib Lulus Kelas: {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <small class="text-secondary mt-1 d-block text-xs">Pilih kelas di atas jika pendaftar
                                (Member) diwajibkan menyelesaikannya terlebih dahulu secara berurutan. (Contoh: DMT
                                butuh siswa lulus CTT).</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.kelas.index') }}"
                                class="btn btn-outline-secondary mb-0 shadow-none">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary mb-0">
                                <i class="fas fa-save me-2"></i>Simpan Kelas Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection