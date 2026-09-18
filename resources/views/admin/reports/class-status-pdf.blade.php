<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Status Kelas Peserta</title>
    <style>
        @page { margin: 22px; }
        body { font-family: DejaVu Sans, sans-serif; color: #263238; font-size: 8px; }
        h1 { color: #344767; font-size: 16px; margin: 0 0 4px; }
        .muted { color: #67748e; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th { background: #344767; color: #fff; font-size: 7px; text-align: left; }
        th, td { border: 1px solid #dfe3e6; padding: 5px 4px; vertical-align: middle; word-wrap: break-word; }
        th:first-child, td:first-child { width: 16%; }
        th:last-child, td:last-child { width: 8%; }
        td { font-size: 7px; }
        .status-indicator { display: inline-block; width: 15px; height: 15px; border-radius: 50%; text-align: center; line-height: 15px; font-weight: bold; }
        .status-completed { color: #198754; background: #d1e7dd; }
        .status-active { color: #b26a00; background: #ffe5b4; }
        .status-pending { color: #6c757d; background: #e9ecef; }
        .status-not-requested { color: #842029; background: #f8d7da; }
        .status-label { display: inline-block; min-width: 42px; padding: 3px 4px; border-radius: 3px; text-align: center; font-weight: bold; }
        .status-label.status-completed { color: #146c43; background: #d1e7dd; }
        .status-label.status-active { color: #8a5300; background: #ffe5b4; }
        .status-label.status-pending { color: #5c636a; background: #e9ecef; }
        .status-label.status-not-requested { color: #842029; background: #f8d7da; }
        .status-label .status-dot { display: inline-block; width: 5px; height: 5px; margin-right: 3px; border-radius: 50%; vertical-align: 1px; background: currentColor; }
        .legend { margin-bottom: 10px; color: #67748e; }
        .legend .status-indicator { margin-right: 3px; }
        .footer { margin-top: 14px; color: #8392ab; font-size: 7px; }
    </style>
</head>
<body>
    <h1>Laporan Status Kelas Peserta</h1>
    <div class="muted">Dicetak: {{ date('d M Y H:i') }}</div>
    <div class="legend"><span class="status-indicator status-completed">&#10003;</span> Selesai &nbsp;&nbsp; <span class="status-indicator status-active">&#9673;</span> Aktif &nbsp;&nbsp; <span class="status-indicator status-pending">&#9677;</span> Pending &nbsp;&nbsp; - Belum</div>

    <table>
        <thead><tr><th>Peserta</th>@foreach($kelases as $kelas)<th>{{ $kelas->nama_kelas }}</th>@endforeach<th>Progress Keseluruhan</th></tr></thead>
        <tbody>
            @forelse($reports as $report)
                <tr><td><strong>{{ $report['participant']->nama_lengkap }}</strong><br>{{ $report['participant']->email }}</td>@foreach($kelases as $kelas)@php($class = $report['classes']->get($kelas->id)) @php($status = $class['status']) @php($statusClass = $status === 'Selesai' ? 'completed' : ($status === 'Aktif' ? 'active' : ($status === 'Pending' ? 'pending' : 'not-requested')))<td>@if($status === 'Belum')-@else<span class="status-label status-{{ $statusClass }}"><span class="status-dot"></span>{{ $status }}</span>@endif</td>@endforeach<td>{{ $report['overall_progress'] }}%</td></tr>
            @empty
                <tr><td colspan="{{ $kelases->count() + 2 }}">Belum ada data peserta.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Equip Discipleship Learning Management System</div>
</body>
</html>
