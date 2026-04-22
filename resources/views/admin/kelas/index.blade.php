@extends('layouts.app')

@section('title', 'Admin CMS - Kelola Kelas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="fas fa-check"></i></span>
                <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-transparent border-bottom mb-3">
                    <h5 class="mb-0">Manajemen Master Kelas</h5>
                    <a href="{{ route('admin.kelas.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Kelas Baru
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="text-uppercase font-weight-bolder opacity-7 px-4">Nama Kelas & Kategori</th>
                                    <th class="text-uppercase font-weight-bolder opacity-7 ps-2">Prasyarat Wajib</th>
                                    <th class="text-center text-uppercase font-weight-bolder opacity-7">Total Video</th>
                                    <th class="text-center text-uppercase font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelases as $k)
                                <tr class="border-bottom">
                                    <td class="px-4">
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset($k->gambar) }}" class="avatar avatar-sm me-3 border-radius-lg bg-cover object-fit-cover" alt="{{ $k->nama_kelas }}">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-dark font-weight-bold">{{ $k->nama_kelas }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $k->kategori }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($k->prasyarat)
                                            <span class="badge badge-sm bg-gradient-warning text-dark px-2 py-1">
                                                <i class="fas fa-lock me-1"></i> Lulus {{ $k->prasyarat->nama_kelas }}
                                            </span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-success px-2 py-1">Bebas Akses (Umum)</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex flex-column gap-2 align-items-center">
                                            <a href="{{ route('admin.materi.index', $k->id) }}" class="btn btn-outline-info btn-sm px-3 mb-0" style="min-width: 140px;">
                                                <i class="fas fa-film me-2"></i> {{ $k->materi->count() }} Video Sesi
                                            </a>
                                            <a href="{{ route('admin.kelas.batches.index', $k->id) }}" class="btn btn-outline-primary btn-sm px-3 mb-0" style="min-width: 140px;">
                                                <i class="fas fa-users me-2"></i> Kelola Batch
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Edit kelas">
                                                <i class="fas fa-pencil-alt text-dark" aria-hidden="true"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini beserta seluruh materinya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-2 mb-0">
                                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-secondary">
                                        Belum ada data kelas yang didaftarkan ke sistem.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
