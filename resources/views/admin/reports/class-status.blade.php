<x-app-layout>
    @section('title', 'Laporan Status Kelas Peserta')

    <style>
        .class-status-report {
            font-size: 0.8rem;
        }

        .class-status-report .page-title {
            font-size: 1.15rem;
        }

        .class-status-report .card-header h5 {
            font-size: 0.95rem;
        }

        .class-status-report .form-label,
        .class-status-report .form-control,
        .class-status-report .form-select,
        .class-status-report .btn {
            font-size: 0.75rem;
        }

        .class-status-report .form-control,
        .class-status-report .form-select {
            min-height: 34px;
            padding: 0.4rem 0.65rem;
        }

        .class-status-report .table {
            font-size: 0.72rem;
        }

        .class-status-report .table th,
        .class-status-report .table td {
            padding: 0.55rem 0.5rem;
            white-space: nowrap;
        }

        .class-status-report .table th {
            font-size: 0.62rem;
        }

        .class-status-report .badge {
            font-size: 0.62rem;
            padding: 0.3rem 0.45rem;
        }

        .class-status-report .status-indicator,
        .participant-detail-report .status-indicator {
            display: inline-flex;
            width: 26px;
            height: 26px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .status-completed { color: #198754; background: #d1e7dd; }
        .status-active { color: #b26a00; background: #ffe5b4; }
        .status-pending { color: #6c757d; background: #e9ecef; }
        .status-not-requested { color: #842029; background: #f8d7da; }

        .status-label {
            display: inline-block;
            min-width: 52px;
            padding: 0.25rem 0.4rem;
            border-radius: 0.35rem;
            font-size: 0.64rem;
            font-weight: 700;
            text-align: center;
        }

        .status-label.status-completed { color: #146c43; background: #d1e7dd; }
        .status-label.status-active { color: #8a5300; background: #ffe5b4; }
        .status-label.status-pending { color: #5c636a; background: #e9ecef; }
        .status-label.status-not-requested { color: #842029; background: #f8d7da; }

        .status-label .status-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            margin-right: 4px;
            border-radius: 50%;
            vertical-align: 1px;
            background: currentColor;
        }

        .status-legend { font-size: 0.7rem; }
        .status-legend .status-indicator { margin-right: 4px; vertical-align: middle; }
    </style>

    <div class="container-fluid py-3 class-status-report">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div><h4 class="mb-1 page-title">Laporan Status Kelas Peserta</h4><p class="text-xs text-secondary mb-0">Pantau status peserta pada setiap kelas.</p></div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-danger mb-0" href="{{ route('admin.reports.class-status.pdf', request()->query()) }}"><i class="fas fa-file-pdf me-2"></i>Export PDF</a>
                <button type="button" class="btn btn-outline-secondary mb-0" onclick="window.print()"><i class="fas fa-print me-2"></i>Print</button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.class-status') }}" class="row align-items-end g-3">
                    <div class="col-lg-3"><label class="form-label text-sm font-weight-bold">Cari peserta</label><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."></div>
                    <div class="col-lg-2"><label class="form-label text-sm font-weight-bold">Status</label><select class="form-select" name="status"><option value="">Semua Status</option>@foreach(['Selesai', 'Aktif', 'Pending', 'Belum'] as $status)<option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>@endforeach</select></div>
                    <div class="col-lg-2"><label class="form-label text-sm font-weight-bold">Department/Kategori</label><select class="form-select" name="category"><option value="">Semua Kategori</option>@foreach($categories as $category)<option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>@endforeach</select></div>
                    <div class="col-lg-2"><label class="form-label text-sm font-weight-bold">Dari tanggal</label><input class="form-control" type="date" name="date_from" value="{{ request('date_from') }}"></div>
                    <div class="col-lg-2"><label class="form-label text-sm font-weight-bold">Sampai tanggal</label><input class="form-control" type="date" name="date_to" value="{{ request('date_to') }}"></div>
                    <div class="col-lg-1"><button class="btn bg-gradient-success mb-0 w-100" type="submit">Filter</button></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-2">Laporan Status Kelas Peserta</h5>
                <div class="status-legend text-secondary mb-2">
                    <span class="status-indicator status-completed" title="Selesai" aria-label="Selesai"><i class="fas fa-check"></i></span> Selesai
                    <span class="status-indicator status-active ms-2" title="Aktif" aria-label="Aktif"><i class="fas fa-spinner fa-spin"></i></span> Aktif
                    <span class="status-indicator status-pending ms-2" title="Pending" aria-label="Pending"><i class="fas fa-clock"></i></span> Pending
                    <span class="ms-2" title="Belum Request" aria-label="Belum Request">-</span> Belum
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead><tr><th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3">Peserta</th>@foreach($displayKelases as $kelas)<th class="text-uppercase text-secondary text-xxs font-weight-bolder">{{ $kelas->nama_kelas }}</th>@endforeach<th class="text-uppercase text-secondary text-xxs font-weight-bolder">Progress Keseluruhan</th></tr></thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr><td class="ps-3"><strong>{{ $report['participant']->nama_lengkap }}</strong><br><small class="text-secondary">{{ $report['participant']->email }}</small></td>@foreach($displayKelases as $kelas)@php($class = $report['classes']->get($kelas->id)) @php($status = $class['status']) @php($statusClass = $status === 'Selesai' ? 'completed' : ($status === 'Aktif' ? 'active' : ($status === 'Pending' ? 'pending' : 'not-requested')))<td>@if($status === 'Belum')<span title="Belum Request" aria-label="Belum Request">-</span>@else<span class="status-label status-{{ $statusClass }}" title="{{ $status }}"><span class="status-dot" aria-hidden="true"></span>{{ $status }}</span>@endif</td>@endforeach<td>{{ $report['overall_progress'] }}%</td></tr>
                            @empty
                                <tr><td colspan="{{ $displayKelases->count() + 2 }}" class="text-center py-4 text-secondary">Belum ada data peserta.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($reports->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                        <small class="text-secondary">Menampilkan {{ $reports->firstItem() }}-{{ $reports->lastItem() }} dari {{ $reports->total() }} peserta</small>
                        <div class="d-flex align-items-center gap-2">
                            @if($reports->onFirstPage())
                                <span class="btn btn-sm btn-light mb-0 disabled">Sebelumnya</span>
                            @else
                                <a class="btn btn-sm btn-outline-secondary mb-0" href="{{ $reports->previousPageUrl() }}">Sebelumnya</a>
                            @endif
                            <small class="text-secondary">Halaman {{ $reports->currentPage() }} dari {{ $reports->lastPage() }}</small>
                            @if($reports->hasMorePages())
                                <a class="btn btn-sm btn-outline-secondary mb-0" href="{{ $reports->nextPageUrl() }}">Berikutnya</a>
                            @else
                                <span class="btn btn-sm btn-light mb-0 disabled">Berikutnya</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
