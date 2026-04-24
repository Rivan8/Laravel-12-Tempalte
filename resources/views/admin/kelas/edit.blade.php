@extends('layouts.app')

@section('title', 'Edit Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 border-bottom bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-pencil-alt text-info me-2"></i>Edit Kelas:
                        <span class="text-primary">{{ $kelas->nama_kelas }}</span>
                    </h5>
                    <p class="text-sm text-secondary mt-1 mb-3">Perbarui informasi kelas di bawah ini.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ── UPLOAD / GANTI GAMBAR COVER ── --}}
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
                                border: 2px solid #3b82f6;
                                cursor: pointer;
                                transition: border-color 0.2s;
                                display: flex; align-items: center; justify-content: center;
                            "
                            onclick="document.getElementById('gambar').click()"
                            ondragover="event.preventDefault(); this.style.borderColor='#2563eb'"
                            ondragleave="this.style.borderColor='#3b82f6'"
                            ondrop="handleDrop(event)">

                                {{-- Gambar existing (default visible) --}}
                                @if($kelas->gambar)
                                <img id="imgPreview" src="{{ asset($kelas->gambar) }}" alt="Cover {{ $kelas->nama_kelas }}"
                                    style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 14px;">
                                @else
                                <img id="imgPreview" src="" alt="Preview"
                                    style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 14px;">
                                @endif

                                {{-- Placeholder (hanya muncul jika tidak ada gambar) --}}
                                <div id="imgPlaceholder" style="text-align: center; pointer-events: none; {{ $kelas->gambar ? 'display:none;' : '' }}">
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

                                {{-- Overlay hover "Ganti Gambar" --}}
                                <div id="imgOverlay" style="
                                    position: absolute; inset: 0;
                                    background: rgba(0,0,0,0.45); border-radius: 14px;
                                    display: flex; align-items: center; justify-content: center;
                                    flex-direction: column; gap: 6px;
                                    opacity: 0; transition: opacity 0.2s;
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

                            {{-- Info: gambar existing --}}
                            @if($kelas->gambar)
                            <div id="existingInfo" style="margin-top: 8px; font-size: 0.78rem; color: #64748b;">
                                <i class="fas fa-image text-info me-1"></i>
                                Gambar saat ini tersimpan. Unggah file baru untuk menggantinya.
                            </div>
                            @endif

                            {{-- Info: setelah pilih file baru --}}
                            <div id="fileInfo" style="margin-top: 8px; font-size: 0.78rem; color: #64748b; display: none;">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                <span id="fileName"></span>
                                <button type="button" onclick="removeImage()" style="
                                    background: none; border: none; color: #ef4444;
                                    font-size: 0.75rem; cursor: pointer; margin-left: 8px; font-weight: 600;
                                ">✕ Batal Ganti</button>
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
                                    value="{{ $kelas->nama_kelas }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    @foreach(['Disciples Community','Equip - New','Equip - Plant','Equip - Grow','Equip - Fruitful','Leadership'] as $kat)
                                    <option value="{{ $kat }}" {{ $kelas->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                    {{-- Tampilkan nilai custom jika tidak ada di list --}}
                                    @if(!in_array($kelas->kategori, ['Disciples Community','Equip - New','Equip - Plant','Equip - Grow','Equip - Fruitful','Leadership']))
                                    <option value="{{ $kelas->kategori }}" selected>{{ $kelas->kategori }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- ── DESKRIPSI ── --}}
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $kelas->deskripsi }}</textarea>
                        </div>

                        {{-- ── LINK KUIS ── --}}
                        <div class="mb-4">
                            <label class="form-label text-sm font-weight-bold">Link Google Form Kuis (Ujian Akhir)</label>
                            <input type="url" name="link_quiz" class="form-control"
                                value="{{ $kelas->link_quiz }}"
                                placeholder="https://forms.gle/xxxxxx">
                            <small class="text-secondary mt-1 d-block text-xs">Biarkan kosong jika tidak ada kuis ujian akhir.</small>
                        </div>

                        {{-- ── MATERI PENDUKUNG ── --}}
                        <div class="mb-4 bg-gray-100 p-3 border-radius-lg">
                            <label class="form-label text-sm font-weight-bold text-dark">
                                <i class="fas fa-file-download text-primary me-2"></i>Materi Pendukung (Optional, hingga 12 file)
                            </label>
                            <small class="text-secondary d-block text-xs mb-3">Abaikan jika tidak ingin mengganti file. Maks 10MB per file. Anda dapat memberikan penamaan khusus untuk tombol download masing-masing file.</small>
                            <div class="row">
                                @php
                                    $materiFields = [
                                        ['name' => 'handbook', 'label' => 'File 1'],
                                        ['name' => 'tools', 'label' => 'File 2'],
                                        ['name' => 'slide', 'label' => 'File 3'],
                                    ];
                                    for ($i = 4; $i <= 12; $i++) {
                                        $materiFields[] = ['name' => 'file_' . $i, 'label' => 'File ' . $i];
                                    }
                                @endphp

                                @foreach($materiFields as $field)
                                    @php
                                        $fieldName = $field['name'];
                                        $customNameField = $fieldName . '_name';
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <div class="border border-radius-md p-2 bg-white h-100">
                                            <span class="badge bg-gradient-info mb-2 text-xxs mb-1">{{ $field['label'] }}</span>

                                            <label class="form-label text-xs font-weight-bold mb-0 mt-1">Nama Tombol Download</label>
                                            <input type="text" name="{{ $customNameField }}" class="form-control form-control-sm mb-2" placeholder="Nama Tombol (Contoh: Download {{ explode(' ', $field['label'])[0] }})" value="{{ old($customNameField, $kelas->$customNameField) }}">

                                            <label class="form-label text-xs font-weight-bold mb-0">Upload File Baru</label>
                                            @if($kelas->$fieldName)
                                            <div class="mb-2 d-flex align-items-center justify-content-between p-1 bg-light rounded text-xs mt-1">
                                                <a href="{{ asset($kelas->$fieldName) }}" target="_blank" class="text-info font-weight-bold text-truncate" style="max-width: 60%; font-size: 0.75rem;">
                                                    <i class="fas fa-file-alt me-1"></i> Lihat File
                                                </a>
                                                <div class="form-check mb-0 border-0 p-0 text-end d-flex align-items-center">
                                                    <input type="checkbox" name="delete_{{ $fieldName }}" id="delete_{{ $fieldName }}" value="1" class="form-check-input m-0 float-none me-1" style="transform: scale(0.85);">
                                                    <label for="delete_{{ $fieldName }}" class="text-danger font-weight-bold mb-0 cursor-pointer" style="font-size: 0.75rem; margin-top: 2px;">
                                                        Hapus
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                            <input type="file" name="{{ $fieldName }}" class="form-control form-control-sm mt-1">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ── PRASYARAT ── --}}
                        <div class="mb-4 bg-light p-3 border-radius-md">
                            <label class="form-label text-dark font-weight-bolder mb-2">
                                <i class="fas fa-lock text-warning me-2"></i>Persyaratan Berantai
                            </label>
                            <select name="prasyarat_kelas_id" class="form-select border-primary">
                                <option value="" {{ is_null($kelas->prasyarat_kelas_id) ? 'selected' : '' }}>-- Bebas Akses (Umum) --</option>
                                @foreach($kelasLain as $k)
                                <option value="{{ $k->id }}" {{ $kelas->prasyarat_kelas_id == $k->id ? 'selected' : '' }}>
                                    Wajib Lulus: {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ── TOMBOL ── --}}
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

<script>
const originalSrc = document.getElementById('imgPreview') ? document.getElementById('imgPreview').src : '';
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
    if (!checkFileSize(input)) return;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
            document.getElementById('fileInfo').style.display = 'block';
            document.getElementById('fileName').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
            const existing = document.getElementById('existingInfo');
            if (existing) existing.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('gambar').value = '';
    // Kembalikan ke gambar lama
    const img = document.getElementById('imgPreview');
    if (originalSrc) {
        img.src = originalSrc;
        img.style.display = 'block';
    }
    document.getElementById('fileInfo').style.display = 'none';
    const existing = document.getElementById('existingInfo');
    if (existing) existing.style.display = 'block';
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('imgPreviewWrapper').style.borderColor = '#3b82f6';
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('gambar');
        input.files = dt.files;
        previewImage(input);
    }
}

// Hover overlay effect
const wrapper = document.getElementById('imgPreviewWrapper');
const overlay = document.getElementById('imgOverlay');
wrapper.addEventListener('mouseenter', () => overlay.style.opacity = '1');
wrapper.addEventListener('mouseleave', () => overlay.style.opacity = '0');
</script>
@endsection
