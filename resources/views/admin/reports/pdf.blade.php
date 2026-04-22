<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Progress - {{ $selectedKelas->nama_kelas }}</title>
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 20px 0 15px;
            border-bottom: 3px solid #344767;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            color: #344767;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header h2 {
            font-size: 13px;
            color: #67748e;
            font-weight: 400;
        }

        .header .subtitle {
            font-size: 10px;
            color: #8392ab;
            margin-top: 4px;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 16px;
            padding: 12px 16px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #344767;
        }

        .info-section table {
            width: 100%;
        }

        .info-section td {
            padding: 2px 8px;
            font-size: 10px;
        }

        .info-label {
            font-weight: 700;
            color: #344767;
            width: 140px;
        }

        .info-value {
            color: #67748e;
        }

        /* Summary Cards */
        .summary-row {
            width: 100%;
            margin-bottom: 16px;
        }

        .summary-row table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .summary-card {
            text-align: center;
            padding: 10px 8px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            width: 25%;
        }

        .summary-card .number {
            font-size: 20px;
            font-weight: 700;
            color: #344767;
            display: block;
        }

        .summary-card .label {
            font-size: 8px;
            text-transform: uppercase;
            color: #8392ab;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table thead tr {
            background-color: #344767;
        }

        .data-table thead th {
            color: #fff;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 6px;
            text-align: left;
            border: none;
        }

        .data-table thead th.center {
            text-align: center;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e9ecef;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tbody td {
            padding: 6px 6px;
            font-size: 9px;
            vertical-align: middle;
        }

        .data-table tbody td.center {
            text-align: center;
        }

        /* Progress Bar */
        .progress-bar-container {
            width: 100%;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 2px;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
        }

        .progress-green { background-color: #2dce89; }
        .progress-blue { background-color: #11cdef; }
        .progress-yellow { background-color: #fb6340; }
        .progress-red { background-color: #f5365c; }
        .progress-gray { background-color: #adb5bd; }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-completed { background-color: #d4edda; color: #155724; }
        .badge-in-progress { background-color: #d1ecf1; color: #0c5460; }
        .badge-requested { background-color: #fff3cd; color: #856404; }

        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            font-size: 8px;
            color: #8392ab;
        }

        .footer .date {
            font-weight: 600;
            color: #67748e;
        }

        /* Page Number */
        .page-number {
            text-align: right;
            font-size: 8px;
            color: #adb5bd;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>📊 Laporan Progress Belajar</h1>
        <h2>Equip Discipleship — Learning Management System</h2>
        <div class="subtitle">Dokumen ini digenerate secara otomatis oleh sistem</div>
    </div>

    {{-- Info Section --}}
    <div class="info-section">
        <table>
            <tr>
                <td class="info-label">Nama Kelas</td>
                <td class="info-value">: {{ $selectedKelas->nama_kelas }}</td>
                <td class="info-label">Kategori</td>
                <td class="info-value">: {{ $selectedKelas->kategori ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Batch</td>
                <td class="info-value">: {{ $selectedBatch->nama_batch }}</td>
                <td class="info-label">Tanggal Mulai</td>
                <td class="info-value">: {{ $selectedBatch->start_date ? $selectedBatch->start_date->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal Cetak</td>
                <td class="info-value">: {{ now()->format('d F Y, H:i') }} WIB</td>
                <td class="info-label">Status Batch</td>
                <td class="info-value">: {{ $selectedBatch->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
        </table>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-row">
        <table>
            <tr>
                <td class="summary-card">
                    <span class="number">{{ $summary['total_peserta'] }}</span>
                    <span class="label">Total Peserta</span>
                </td>
                <td class="summary-card">
                    <span class="number">{{ $summary['avg_progress'] }}%</span>
                    <span class="label">Rata-rata Progress</span>
                </td>
                <td class="summary-card">
                    <span class="number">{{ $summary['completed_count'] }}</span>
                    <span class="label">Sudah Selesai</span>
                </td>
                <td class="summary-card">
                    <span class="number">{{ $summary['not_started_count'] }}</span>
                    <span class="label">Belum Mulai</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;" class="center">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. HP</th>
                <th class="center">JK</th>
                <th class="center">Role</th>
                <th class="center">Status</th>
                <th style="width: 50px;" class="center">Progress</th>
                <th style="width: 80px;">Persentase</th>
                <th class="center">Bergabung</th>
                <th class="center">Terakhir Aktif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr>
                <td class="center">{{ $report['no'] }}</td>
                <td><strong>{{ $report['user_name'] }}</strong></td>
                <td>{{ $report['user_email'] }}</td>
                <td>{{ $report['user_phone'] }}</td>
                <td class="center">
                    @if($report['user_gender'] === 'Laki laki' || $report['user_gender'] === 'Laki-laki')
                        L
                    @elseif($report['user_gender'] === 'Perempuan')
                        P
                    @else
                        -
                    @endif
                </td>
                <td class="center">{{ $report['user_role'] }}</td>
                <td class="center">
                    @php
                        $statusLabels = [
                            'completed' => 'Selesai',
                            'in_progress' => 'Berlangsung',
                            'requested' => 'Menunggu',
                        ];
                        $badgeClass = 'badge-' . str_replace('_', '-', $report['status']);
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $statusLabels[$report['status']] ?? ucfirst($report['status']) }}
                    </span>
                </td>
                <td class="center">{{ $report['completed'] }}/{{ $report['total'] }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 4px;">
                        <span style="font-weight: 700; min-width: 28px;">{{ $report['percentage'] }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        @php
                            $pct = $report['percentage'];
                            if ($pct >= 100) $barColor = 'progress-green';
                            elseif ($pct >= 60) $barColor = 'progress-blue';
                            elseif ($pct >= 30) $barColor = 'progress-yellow';
                            elseif ($pct > 0) $barColor = 'progress-red';
                            else $barColor = 'progress-gray';
                        @endphp
                        <div class="progress-bar-fill {{ $barColor }}" style="width: {{ $pct }}%;"></div>
                    </div>
                </td>
                <td class="center">
                    {{ $report['joined_at'] ? \Carbon\Carbon::parse($report['joined_at'])->format('d/m/Y') : '-' }}
                </td>
                <td class="center">
                    {{ $report['last_activity'] ? \Carbon\Carbon::parse($report['last_activity'])->format('d/m/Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center; padding: 20px; color: #8392ab;">
                    Belum ada data peserta di batch ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <p>Laporan ini digenerate oleh <strong>Equip Discipleship LMS</strong></p>
        <p class="date">{{ now()->format('l, d F Y') }} — {{ now()->format('H:i') }} WIB</p>
        <p style="margin-top: 4px;">© {{ date('Y') }} Elshaddai Church. All rights reserved.</p>
    </div>

</body>
</html>
