<x-app-layout>
    @section('title', 'Laporan Progress')

    <div class="container-fluid py-4">
        {{-- Page Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-dark overflow-hidden">
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon icon-shape icon-md bg-white shadow-sm border-radius-md text-center me-3 d-flex align-items-center justify-content-center" style="min-width: 42px; min-height: 42px;">
                                        <i class="fas fa-chart-line text-dark fs-5"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-weight-bolder mb-0">Laporan Progress Belajar</h4>
                                        <p class="text-white text-sm mb-0 opacity-8">Pantau perkembangan belajar peserta secara real-time</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                @if($selectedBatch && count($reports) > 0)
                                <a href="{{ route('admin.reports.pdf', ['kelas_id' => $selectedKelas->id, 'batch_id' => $selectedBatch->id]) }}"
                                   class="btn btn-white btn-sm mb-0 d-inline-flex align-items-center" id="btn-download-pdf">
                                    <i class="fas fa-file-pdf me-2 text-danger"></i>
                                    <span>Download PDF</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        {{-- Decorative shapes --}}
                        <div class="position-absolute top-0 end-0 me-n4 mt-n4 opacity-2">
                            <i class="fas fa-graduation-cap" style="font-size: 8rem; color: #fff;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.reports.index') }}" method="GET" id="filter-form">
                            <div class="row align-items-end g-3">
                                <div class="col-md-5">
                                    <label for="kelas_id" class="form-label text-uppercase text-xs font-weight-bolder text-secondary mb-2">
                                        <i class="fas fa-book-open me-1"></i> Pilih Kelas
                                    </label>
                                    <select name="kelas_id" id="kelas_id" class="form-select border-radius-md" onchange="this.form.submit()" style="padding: 0.6rem 0.9rem; border: 1px solid #dee2e6;">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelases as $kelas)
                                            <option value="{{ $kelas->id }}" {{ $selectedKelas && $selectedKelas->id == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($selectedKelas)
                                <div class="col-md-5">
                                    <label for="batch_id" class="form-label text-uppercase text-xs font-weight-bolder text-secondary mb-2">
                                        <i class="fas fa-layer-group me-1"></i> Pilih Batch
                                    </label>
                                    <select name="batch_id" id="batch_id" class="form-select border-radius-md" onchange="this.form.submit()" style="padding: 0.6rem 0.9rem; border: 1px solid #dee2e6;">
                                        <option value="">-- Pilih Batch --</option>
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" {{ $selectedBatch && $selectedBatch->id == $batch->id ? 'selected' : '' }}>
                                                {{ $batch->nama_batch }}
                                                @if($batch->start_date)
                                                    ({{ $batch->start_date->format('d M Y') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if($selectedBatch && count($reports) > 0)
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-end-0" style="border: 1px solid #dee2e6;">
                                            <i class="fas fa-search text-secondary text-xs"></i>
                                        </span>
                                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0"
                                               placeholder="Cari nama..."
                                               style="padding: 0.6rem 0.5rem; border: 1px solid #dee2e6; border-left: none;">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($selectedBatch && count($reports) > 0)
        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Total Peserta</p>
                                    <h4 class="font-weight-bolder mb-0 mt-1" id="stat-total">
                                        {{ $summary['total_peserta'] }}
                                    </h4>
                                    <p class="text-xs text-secondary mb-0 mt-1">
                                        <i class="fas fa-users me-1"></i> Peserta terdaftar
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                    <i class="fas fa-users text-lg text-white opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Rata-rata Progress</p>
                                    <h4 class="font-weight-bolder mb-0 mt-1" id="stat-avg">
                                        {{ $summary['avg_progress'] }}%
                                    </h4>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-info" style="width: {{ $summary['avg_progress'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                    <i class="fas fa-chart-pie text-lg text-white opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Sudah Selesai</p>
                                    <h4 class="font-weight-bolder mb-0 mt-1" id="stat-completed">
                                        {{ $summary['completed_count'] }}
                                    </h4>
                                    <p class="text-xs mb-0 mt-1">
                                        <span class="text-success font-weight-bolder"><i class="fas fa-check-circle me-1"></i>100%</span> completed
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                    <i class="fas fa-trophy text-lg text-white opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Belum Mulai</p>
                                    <h4 class="font-weight-bolder mb-0 mt-1" id="stat-notstarted">
                                        {{ $summary['not_started_count'] }}
                                    </h4>
                                    <p class="text-xs mb-0 mt-1">
                                        <span class="text-danger font-weight-bolder"><i class="fas fa-exclamation-circle me-1"></i>0%</span> progress
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                    <i class="fas fa-hourglass-start text-lg text-white opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">
                                <i class="fas fa-table me-2 text-primary"></i>
                                Detail Progress Peserta
                            </h6>
                            <p class="text-xs text-secondary mb-0 mt-1">
                                {{ $selectedKelas->nama_kelas }} — {{ $selectedBatch->nama_batch }}
                                @if($selectedBatch->start_date)
                                    <span class="ms-1">(Mulai: {{ $selectedBatch->start_date->format('d M Y') }})</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-gradient-dark px-3 py-2">
                                <i class="fas fa-video me-1"></i> {{ $reports[0]['total'] ?? 0 }} Materi
                            </span>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="reportTable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3" style="width: 40px;">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Peserta</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Gender</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Role</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Progress</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Bergabung</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Terakhir Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr class="report-row" style="animation: fadeInUp 0.4s ease {{ $loop->index * 0.03 }}s both;">
                                        <td class="ps-3">
                                            <span class="text-xs font-weight-bold">{{ $report['no'] }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="avatar avatar-sm bg-gradient-{{ $report['percentage'] >= 100 ? 'success' : ($report['percentage'] > 0 ? 'info' : 'secondary') }} border-radius-md me-3 d-flex align-items-center justify-content-center shadow-sm" style="min-width: 36px; min-height: 36px;">
                                                    <span class="text-white text-xs font-weight-bold">
                                                        {{ strtoupper(substr($report['user_name'], 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $report['user_name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $report['user_email'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $report['user_phone'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if($report['user_gender'] === 'Laki laki' || $report['user_gender'] === 'Laki-laki')
                                                <span class="badge badge-sm bg-gradient-info px-2 py-1"><i class="fas fa-mars me-1"></i>L</span>
                                            @elseif($report['user_gender'] === 'Perempuan')
                                                <span class="badge badge-sm bg-gradient-danger px-2 py-1" style="background-image: linear-gradient(310deg, #f5365c 0%, #f56036 100%);"><i class="fas fa-venus me-1"></i>P</span>
                                            @else
                                                <span class="text-xs text-secondary">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $roleColors = [
                                                    'Admin' => 'danger',
                                                    'Fasilitator' => 'warning',
                                                ];
                                                $roleBg = $roleColors[$report['user_role']] ?? 'dark';
                                            @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $roleBg }} px-2 py-1">{{ $report['user_role'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusConfig = [
                                                    'completed' => ['color' => 'success', 'icon' => 'check-circle', 'label' => 'Selesai'],
                                                    'in_progress' => ['color' => 'info', 'icon' => 'spinner', 'label' => 'On-Going'],
                                                    'requested' => ['color' => 'warning', 'icon' => 'clock', 'label' => 'Menunggu'],
                                                ];
                                                $sc = $statusConfig[$report['status']] ?? ['color' => 'secondary', 'icon' => 'question', 'label' => ucfirst($report['status'])];
                                            @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $sc['color'] }} px-2 py-1">
                                                <i class="fas fa-{{ $sc['icon'] }} me-1"></i>{{ $sc['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="min-width: 140px;">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="text-xs font-weight-bold me-2" style="min-width: 32px;">{{ $report['percentage'] }}%</span>
                                                    <span class="text-xs text-secondary">{{ $report['completed'] }}/{{ $report['total'] }}</span>
                                                </div>
                                                <div class="progress" style="height: 6px; border-radius: 4px;">
                                                    @php
                                                        $pct = $report['percentage'];
                                                        if ($pct >= 100) $barClass = 'bg-gradient-success';
                                                        elseif ($pct >= 60) $barClass = 'bg-gradient-info';
                                                        elseif ($pct >= 30) $barClass = 'bg-gradient-warning';
                                                        elseif ($pct > 0) $barClass = 'bg-gradient-danger';
                                                        else $barClass = 'bg-secondary';
                                                    @endphp
                                                    <div class="progress-bar {{ $barClass }}" role="progressbar"
                                                         style="width: {{ $pct }}%; transition: width 1s ease {{ $loop->index * 0.05 }}s;"
                                                         aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-xs text-secondary">
                                                {{ $report['joined_at'] ? \Carbon\Carbon::parse($report['joined_at'])->format('d M Y') : '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($report['last_activity'])
                                                <span class="text-xs text-secondary" title="{{ \Carbon\Carbon::parse($report['last_activity'])->format('d M Y H:i') }}">
                                                    {{ \Carbon\Carbon::parse($report['last_activity'])->diffForHumans() }}
                                                </span>
                                            @else
                                                <span class="text-xs text-secondary opacity-5">Belum ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($selectedBatch && count($reports) == 0)
        {{-- Empty state when batch selected but no users --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-inbox text-secondary" style="font-size: 3.5rem; opacity: 0.3;"></i>
                        </div>
                        <h6 class="text-secondary">Belum Ada Peserta</h6>
                        <p class="text-xs text-secondary mb-0">Batch ini belum memiliki peserta yang terdaftar.</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        {{-- Prompt state --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-hand-pointer text-primary" style="font-size: 3.5rem; opacity: 0.3;"></i>
                        </div>
                        @if($selectedKelas)
                            <h6 class="text-secondary">Pilih Batch</h6>
                            <p class="text-xs text-secondary mb-0">Silakan pilih batch untuk melihat laporan progress peserta.</p>
                        @else
                            <h6 class="text-secondary">Pilih Kelas Terlebih Dahulu</h6>
                            <p class="text-xs text-secondary mb-0">Gunakan filter di atas untuk memilih kelas dan batch yang ingin dilihat.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('styles')
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-row {
            transition: all 0.2s ease;
        }

        .report-row:hover {
            background-color: rgba(203, 12, 159, 0.02);
            transform: scale(1.001);
        }

        .report-row:hover td {
            border-color: rgba(203, 12, 159, 0.08);
        }

        .form-select:focus {
            border-color: #cb0c9f;
            box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.1);
        }

        .form-control:focus {
            border-color: #cb0c9f;
            box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.1);
        }

        #btn-download-pdf {
            transition: all 0.3s ease;
            font-weight: 600;
        }

        #btn-download-pdf:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card {
            transition: box-shadow 0.3s ease;
        }

        .progress-bar {
            border-radius: 4px;
        }

        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Client-side search filter
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#reportTable tbody .report-row');
                    
                    rows.forEach(function(row) {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(filter)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
