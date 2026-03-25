@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            @if(session('success'))
                <div class="alert alert-success text-white text-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Daftar Pengajuan Kelas Tertunda</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas Requested</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Request</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div class="avatar avatar-sm me-3 bg-gradient-info text-white text-uppercase">
                                                    {{ substr($req->nama_lengkap, 0, 2) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $req->nama_lengkap }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $req->email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $req->nama_kelas }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($req->request_date)->format('d M Y') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('users.approve', ['user_id' => $req->user_id, 'kelas_id' => $req->kelas_id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm bg-gradient-success mb-0" data-toggle="tooltip" data-original-title="Approve request">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">Tidak ada pengajuan kelas yang tertunda saat ini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Master User List Table -->
            <div class="card mt-4 mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Daftar Seluruh Pengguna & Fasilitator</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0" style="max-height: 500px; overflow-y: auto;">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member Info</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Handphone</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Gabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($user->role === 'Admin')
                                                    <div class="avatar avatar-sm me-3 bg-gradient-danger text-white text-uppercase">
                                                @elseif($user->role === 'Fasilitator')
                                                    <div class="avatar avatar-sm me-3 bg-gradient-warning text-white text-uppercase">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-info text-white text-uppercase">
                                                @endif
                                                    {{ substr($user->nama_lengkap ?? $user->name, 0, 2) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->nama_lengkap ?? $user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            @if($user->role === 'Admin')
                                                <span class="badge badge-sm bg-gradient-danger">Admin</span>
                                            @elseif($user->role === 'Fasilitator')
                                                <span class="badge badge-sm bg-gradient-warning">Fasilitator</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Member</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $user->no_hp ?? '-' }}</p>
                                        <p class="text-xxs text-secondary mb-0">{{ $user->jenis_kelamin ?? '' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d M Y') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">Belum ada pengguna terdaftar di database.</p>
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
