@extends('layouts.app')

@section('title', 'Tambah Master Kelas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Tambah Master Kelas Baru</h5>
                    <p class="text-sm text-secondary mt-1 mb-3">Isi semua informasi kelas yang ingin Anda buat.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ── UPLOAD GAMBAR COVER ── --}}
                        <div class="mb-4">
                            <label class="form-label text-sm font-weight-bold d-flex align-items-center gap-2">
                                <i class="fas fa-image text-info"></i> Cover / Gambar Kelas
                            </label>

                            {{-- Preview Area --}}
                            <div id="imgPreviewWrapper" style="
                                position: relative;
                                width: 100%; height: 220px;
                                border-radius: 16px; overflow: hidden;
                                background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
                                border: 2px dashed #cbd5e1;
                                cursor: pointer;
                                transition: border-color 0.2s;
                                display: flex; align-items: center; justify-content: center;
                            "
                            onclick="document.getElementById('gambar').click()"
                            ondragover="event.preventDefault(); this.style.borderColor='#3b82f6'"
                            ondragleave="this.style.borderColor='#cbd5e1'"
                            ondrop="handleDrop(event)">

                                {{-- Placeholder (default) --}}
                                <div id="imgPlaceholder" style="text-align: center; pointer-events: none;">
                                    <div style="
                                        width: 56px; height: 56px; border-radius: 16px;
                                        background: linear-gradient(135deg, #3b82f6, #60a5fa);
                                        display: flex; align-items: center; justify-content: center;
                                        margin: 0 auto 12px;
                                    ">
                                        <i class="fas fa-cloud-upload-alt text-white" style="font-size: 1.4rem;"></i>
                                    </div>
                                    <p style="font-size: 0.88rem; font-weight: 600; color: #475569; margin: 0 0 4px;">
                                        Klik atau seret gambar ke sini
                                    </p>
                                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">
                                        JPG, PNG, WEBP — Maks. 2MB
                                    </p>
                                </div>

                                {{-- Preview Image --}}
                                <img id="imgPreview" src="" alt="Preview"
                                    style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 14px;">

                                {{-- Overlay Ganti saat ada preview --}}
                                <div id="imgOverlay" style="
                                    display: none; position: absolute; inset: 0;
                                    background: rgba(0,0,0,0.45); border-radius: 14px;
                                    align-items: center; justify-content: center;
                                    flex-direction: column; gap: 6px;
                                ">
                                    <i class="fas fa-camera text-white" style="font-size: 1.5rem;"></i>
                                    <span style="color: #fff; font-size: 0.8rem; font-weight: 600;">Klik untuk ganti gambar</span>
                                </div>
                            </div>

                            {{-- File Input (hidden) --}}
                            <input type="file" id="gambar" name="gambar"
                                accept="image/jpeg,image/png,image/webp"
                                style="display: none;"
                                onchange="previewImage(this)" oninput="checkFileSize(this)">

                            {{-- Nama file info --}}
                            <div id="fileInfo" style="margin-top: 8px; font-size: 0.78rem; color: #64748b; display: none;">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                <span id="fileName"></span>
                                <button type="button" onclick="removeImage()" style="
                                    background: none; border: none; color: #ef4444;
                                    font-size: 0.75rem; cursor: pointer; margin-left: 8px;
                                    font-weight: 600;
                                ">✕ Hapus</button>
                            </div>

                            {{-- Keterangan ukuran file --}}
                            <div style="
                                display: flex; align-items: flex-start; gap: 8px;
                                margin-top: 10px; padding: 10px 14px;
                                background: #fffbeb; border: 1px solid #fde68a;
                                border-radius: 10px;
                            ">
                                <i class="fas fa-info-circle" style="color: #f59e0b; margin-top: 1px; flex-shrink: 0;"></i>
                                <div style="font-size: 0.78rem; color: #92400e; line-height: 1.5;">
                                    <strong>Ketentuan upload gambar:</strong><br>
                                    Format: <code>JPG, JPEG, PNG, WEBP</code> &nbsp;•&nbsp;
                                    Ukuran maksimal: <strong>2 MB</strong><br>
                                    Resolusi rekomendasi: <strong>800×450 px</strong> (landscape 16:9)
                                </div>
                            </div>

                            {{-- Pesan error ukuran (JS) --}}
                            <div id="sizeError" style="display:none; margin-top:8px; padding: 8px 12px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; font-size:0.78rem; color:#b91c1c;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <strong>File terlalu besar!</strong> Ukuran gambar melebihi <strong>2 MB</strong>. Silakan pilih file yang lebih kecil.
                            </div>

                            @error('gambar')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ── NAMA & KATEGORI ── --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nama Kelas</label>
                                <input type="text" name="nama_kelas" class="form-control"
                                    placeholder="Contoh: Foundation Class 1"
                                    value="{{ old('nama_kelas') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Disciples Community" {{ old('kategori') == 'Disciples Community' ? 'selected' : '' }}>Disciples Community</option>
                                    <option value="Equip - New"         {{ old('kategori') == 'Equip - New'         ? 'selected' : '' }}>Equip - New</option>
                                    <option value="Equip - Plant"        {{ old('kategori') == 'Equip - Plant'        ? 'selected' : '' }}>Equip - Plant</option>
                                    <option value="Equip - Grow"         {{ old('kategori') == 'Equip - Grow'         ? 'selected' : '' }}>Equip - Grow</option>
                                    <option value="Equip - Fruitful"     {{ old('kategori') == 'Equip - Fruitful'     ? 'selected' : '' }}>Equip - Fruitful</option>
                                    <option value="Leadership"           {{ old('kategori') == 'Leadership'           ? 'selected' : '' }}>Leadership</option>
                                </select>
                            </div>
                        </div>

                        {{-- ── DESKRIPSI ── --}}
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="4"
                                placeholder="Tuliskan ulasan mengenai kurikulum kelas ini..." required>{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- ── LINK KUIS ── --}}
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Link Google Form Kuis (Ujian Akhir)</label>
                            <input type="url" name="link_quiz" class="form-control"
                                placeholder="https://forms.gle/xxxxxx"
                                value="{{ old('link_quiz') }}">
                            <small class="text-secondary mt-1 d-block text-xs">Biarkan kosong jika tidak ada kuis ujian akhir.</small>
                        </div>

                        {{-- ── PRASYARAT ── --}}
                        <div class="mb-4 bg-light p-3 border-radius-md">
                            <label class="form-label text-dark font-weight-bolder mb-2">
                                <i class="fas fa-lock text-warning me-2"></i>Persyaratan Mengikuti Kelas
                            </label>
                            <select name="prasyarat_kelas_id" class="form-select border-primary">
                                <option value="">-- Bebas Akses (Tidak ada syarat) --</option>
                                @foreach($kelasLain as $k)
                                <option value="{{ $k->id }}" {{ old('prasyarat_kelas_id') == $k->id ? 'selected' : '' }}>
                                    Wajib Lulus: {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-secondary mt-1 d-block text-xs">Pilih jika peserta wajib menyelesaikan kelas lain terlebih dahulu.</small>
                        </div>

                        {{-- ── TOMBOL ── --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary mb-0 shadow-none">Batal</a>
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

<script>
const MAX_SIZE_MB = 2;

function checkFileSize(input) {
    const sizeError = document.getElementById('sizeError');
    const submitBtn = document.querySelector('button[type="submit"]');
    if (input.files && input.files[0]) {
        const sizeMB = input.files[0].size / (1024 * 1024);
        if (sizeMB > MAX_SIZE_MB) {
            sizeError.style.display = 'block';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.classList.add('opacity-5'); }
            return false;
        } else {
            sizeError.style.display = 'none';
            if (submitBtn) { submitBtn.disabled = false; submitBtn.classList.remove('opacity-5'); }
            return true;
        }
    }
    return true;
}

function previewImage(input) {
    if (!checkFileSize(input)) return; // stop jika file terlalu besar
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreview').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
            document.getElementById('imgOverlay').style.display = 'flex';
            document.getElementById('imgPreviewWrapper').style.borderStyle = 'solid';
            document.getElementById('imgPreviewWrapper').style.borderColor = '#3b82f6';
            document.getElementById('fileInfo').style.display = 'block';
            document.getElementById('fileName').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('gambar').value = '';
    document.getElementById('imgPreview').src = '';
    document.getElementById('imgPreview').style.display = 'none';
    document.getElementById('imgPlaceholder').style.display = 'block';
    document.getElementById('imgOverlay').style.display = 'none';
    document.getElementById('imgPreviewWrapper').style.borderStyle = 'dashed';
    document.getElementById('imgPreviewWrapper').style.borderColor = '#cbd5e1';
    document.getElementById('fileInfo').style.display = 'none';
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('imgPreviewWrapper').style.borderColor = '#cbd5e1';
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('gambar');
        input.files = dt.files;
        previewImage(input);
    }
}

// Hover overlay
document.getElementById('imgPreviewWrapper').addEventListener('mouseenter', function() {
    const overlay = document.getElementById('imgOverlay');
    if (overlay.style.display === 'flex') overlay.style.opacity = '1';
});
</script>
@endsection