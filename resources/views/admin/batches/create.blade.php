@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">Tambah Batch Baru</h3>
                    </div>
                    <p class="mt-2 text-sm">Atur periode batch untuk kelas <span class="font-weight-bold">{{ $kelas->nama_kelas }}</span>.</p>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.kelas.batches.store', $kelas->id) }}" method="POST" class="mt-6 space-y-4">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_batch" class="form-control-label">Nama Batch</label>
                                    <input type="text" name="nama_batch" id="nama_batch" value="{{ old('nama_batch') }}"
                                        placeholder="Contoh: Batch April 2026"
                                        class="form-control @error('nama_batch') is-invalid @enderror">
                                    @error('nama_batch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-control-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                        class="form-control @error('start_date') is-invalid @enderror">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Aktifkan Batch</label>
                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1">
                                        <label class="form-check-label" for="is_active">
                                            Status: <span id="activeStatusLabel" class="text-info">Nonaktif</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Jika diaktifkan, batch ini akan menjadi default</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.kelas.batches.index', $kelas->id) }}"
                                class="btn btn-light btn-md mb-0">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn btn-primary btn-md mb-0">
                                Simpan Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const toggle = document.getElementById('is_active');
    const statusLabel = document.getElementById('activeStatusLabel');

    toggle.addEventListener('change', function () {
        if (this.checked) {
            statusLabel.textContent = 'Aktif';
            statusLabel.className = 'text-success'; // Change to green when active
        } else {
            statusLabel.textContent = 'Nonaktif';
            statusLabel.className = 'text-info'; // Keep blue when inactive
        }
    });
    
    // Initialize label state based on checkbox
    if (!toggle.checked) {
        statusLabel.textContent = 'Nonaktif';
        statusLabel.className = 'text-info';
    } else {
        statusLabel.textContent = 'Aktif';
        statusLabel.className = 'text-success';
    }
</script>
@endsection