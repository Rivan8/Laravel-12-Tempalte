@extends('layouts.app')

@section('title', 'Edit Role Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card mb-4 shadow-sm">
                <div class="card-header pb-0 border-bottom">
                    <h6><i class="fas fa-user-edit text-primary me-2"></i>Edit Role Pengguna</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Readonly -->
                        <div class="mb-3">
                            <label class="form-control-label">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->nama_lengkap ?? $user->name }}" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-control-label">Email</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-control-label">Status Terkini</label><br>
                            <span class="badge bg-gradient-info">{{ $user->status_user }}</span>
                            <span class="badge bg-gradient-primary ms-1">Equip: {{ $user->equip_status }}</span>
                        </div>

                        <!-- Editable Role -->
                        <div class="mb-4">
                            <label for="role" class="form-control-label">Akses Role (Jabatan Sistem)</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="Member" {{ $user->role === 'Member' ? 'selected' : '' }}>Member (Hak Akses Biasa)</option>
                                <option value="Fasilitator" {{ $user->role === 'Fasilitator' ? 'selected' : '' }}>Fasilitator (Bisa mendampingi dan akses bebas kelas)</option>
                                <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin (Hak Akses Penuh Sistem)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-xs text-secondary mt-2 d-block">Peringatan: Memberikan role 'Admin' akan membuka seluruh akses panel manajemen pendaftaran dan materi.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-light mb-0 me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
