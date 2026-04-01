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

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid rgba(0,0,0,.05);">
                    <div class="d-flex align-items-center gap-3">
                        <h6 class="mb-0"><i class="fas fa-inbox me-2 text-primary"></i>Daftar Pengajuan Kelas Tertunda</h6>
                        @if(isset($pendingRequestCount) && $pendingRequestCount > 0)
                        <span style="
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            min-width: 24px;
                            height: 24px;
                            padding: 0 7px;
                            background: linear-gradient(310deg, #f5365c 0%, #f56036 100%);
                            color: #fff;
                            font-size: 0.75rem;
                            font-weight: 700;
                            border-radius: 50px;
                            box-shadow: 0 3px 10px rgba(245,54,92,0.4);
                            animation: badge-pulse 2s infinite;
                        ">{{ $pendingRequestCount }}</span>
                        @endif
                    </div>
                    @if(isset($pendingRequestCount) && $pendingRequestCount > 0)
                    <span class="text-xs text-secondary">Ada <strong class="text-danger">{{ $pendingRequestCount }}</strong> request menunggu konfirmasi</span>
                    @endif
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
                                <tr class="border-bottom kelas-request-row request-status-new">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div class="avatar avatar-sm me-3 bg-gradient-info text-white text-uppercase" style="font-size: 0.8rem; font-weight: 700;">
                                                    {{ substr($req->nama_lengkap, 0, 2) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $req->nama_lengkap }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $req->email }}</p>
                                    </td>
                                    <td class="py-3">
                                        <span class="kelas-request-badge">
                                            <i class="fas fa-graduation-cap" style="font-size: 0.65rem;"></i>
                                            {{ $req->nama_kelas }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse(trim($req->request_date, "'"))->format('d M Y') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('users.approve', ['user_id' => $req->user_id, 'kelas_id' => $req->kelas_id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm bg-gradient-success mb-0" data-toggle="tooltip" data-original-title="Approve request">
                                                <i class="fas fa-check me-1"></i>Konfirmasi
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
                    <!-- Form Search -->
                    <form action="{{ route('users.index') }}" method="GET" class="d-flex align-items-center ms-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, hp..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mb-0 ms-2">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-light mb-0 ms-2">Reset</a>
                        @endif
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member Info</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role & Kontak</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenjang / Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Progres Kelas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Gabung</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
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
                                        <p class="text-xs font-weight-bold mb-1">
                                            @if($user->role === 'Admin')
                                                <span class="badge badge-sm bg-gradient-danger">Admin</span>
                                            @elseif($user->role === 'Fasilitator')
                                                <span class="badge badge-sm bg-gradient-warning">Fasilitator</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Member</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-secondary mb-0"><i class="fas fa-phone-alt me-1"></i> {{ $user->no_hp ?? '-' }}</p>
                                    </td>
                                    <td>
                                        @php
                                            $dmStatus = $user->status_user;
                                            $eqStatus = $user->equip_status;
                                        @endphp
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge badge-sm {{ $dmStatus === 'Disciple Maker (DM)' ? 'bg-gradient-success' : ($dmStatus === 'Core Team' ? 'bg-gradient-info' : 'bg-gradient-light text-secondary') }} w-auto d-inline-block" style="max-width: fit-content;">
                                                <i class="fas fa-crown me-1 text-xxs"></i> {{ $dmStatus }}
                                            </span>
                                            <span class="badge badge-sm bg-gradient-primary w-auto d-inline-block" style="max-width: fit-content;">
                                                <i class="fas fa-layer-group me-1 text-xxs"></i> Equip: {{ $eqStatus }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1 text-sm pt-2">
                                            @php
                                                $completedCount = $user->kelas->where('pivot.status', 'completed')->count();
                                                $activeCount = $user->kelas->where('pivot.status', 'in_progress')->count();
                                                $pendingCount = $user->kelas->where('pivot.status', 'requested')->count();
                                            @endphp
                                            
                                            <div class="d-flex justify-content-between text-success mb-0" style="width: 120px;">
                                                <span><i class="fas fa-check-circle me-1"></i> Selesai:</span>
                                                <span class="font-weight-bold">{{ $completedCount }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between text-warning mb-0" style="width: 120px;">
                                                <span><i class="fas fa-spinner fa-spin me-1"></i> Aktif:</span>
                                                <span class="font-weight-bold">{{ $activeCount }}</span>
                                            </div>
                                            @if($pendingCount > 0)
                                            <div class="d-flex justify-content-between text-secondary mb-0" style="width: 120px;">
                                                <span><i class="fas fa-clock me-1"></i> Pending:</span>
                                                <span class="font-weight-bold">{{ $pendingCount }}</span>
                                            </div>
                                            @endif

                                            @if($user->kelas->count() > 0)
                                            <button type="button" class="btn btn-sm btn-link text-primary p-0 m-0 text-start mt-2" data-bs-toggle="modal" data-bs-target="#progressModal-{{ $user->id }}">
                                                Lihat Rincian <i class="fas fa-arrow-right text-xs ms-1"></i>
                                            </button>
                                            
                                            <!-- Modal Rincian Kelas -->
                                            <div class="modal fade" id="progressModal-{{ $user->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $user->id }}" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel-{{ $user->id }}">
                                                        <i class="fas fa-book-open text-primary me-2"></i>Histori Pembelajaran
                                                    </h5>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body p-0">
                                                    <ul class="list-group list-group-flush">
                                                        @foreach($user->kelas->sortBy('pivot.status') as $k)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                                <div>
                                                                    <h6 class="mb-0 text-sm font-weight-bold">{{ $k->nama_kelas }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $k->kategori }}</p>
                                                                </div>
                                                                <div>
                                                                    @if($k->pivot->status === 'completed')
                                                                        <span class="badge bg-gradient-success">Selesai</span>
                                                                    @elseif($k->pivot->status === 'in_progress')
                                                                        <span class="badge bg-gradient-warning">Sedang Aktif</span>
                                                                    @else
                                                                        <span class="badge border border-secondary text-secondary bg-transparent">Menunggu</span>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            @else
                                                <span class="text-xs text-muted font-italic mt-2">Belum ada data kelas</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at ? \Carbon\Carbon::parse(trim($user->created_at, "'"))->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-info mb-0 d-flex align-items-center justify-content-center mx-auto" style="max-width: fit-content;">
                                            <i class="fas fa-user-edit me-1"></i> Edit Role
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">Belum ada pengguna terdaftar.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                @if($users->hasPages())
                <div class="card-footer px-4 border-top">
                    {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
