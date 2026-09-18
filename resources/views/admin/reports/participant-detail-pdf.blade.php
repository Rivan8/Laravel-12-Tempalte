<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Peserta</title>
    <style>
        @page { margin: 28px; }
        body { font-family: DejaVu Sans, sans-serif; color: #263238; font-size: 10px; }
        h1 { color: #344767; font-size: 18px; margin: 0 0 4px; }
        h2 { font-size: 13px; margin: 18px 0 8px; color: #344767; }
        .muted { color: #67748e; }
        .summary { width: 100%; margin: 16px 0; }
        .summary td { width: 25%; padding: 10px; background: #f4f6f8; border: 1px solid #e1e5e8; }
        .summary strong { display: block; font-size: 16px; color: #344767; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #344767; color: #fff; text-align: left; font-size: 9px; }
        th, td { border: 1px solid #dfe3e6; padding: 7px; }
        td { font-size: 9px; }
        .status { font-weight: bold; }
        .footer { margin-top: 18px; font-size: 8px; color: #8392ab; }
    </style>
</head>
<body>
    <h1>Laporan Detail Peserta</h1>
    <div class="muted">Dicetak: {{ date('d M Y H:i') }}</div>

    <h2>Informasi Peserta</h2>
    <table>
        <tr><td><strong>Nama</strong><br>{{ $participant->nama_lengkap }}</td><td><strong>ID</strong><br>{{ $participant->id }}</td><td><strong>Email</strong><br>{{ $participant->email }}</td><td><strong>Telepon</strong><br>{{ $participant->no_hp ?: '-' }}</td></tr>
    </table>

    <table class="summary">
        <tr><td>Total Kelas<strong>{{ $classReports->count() }}</strong></td><td>Kelas Selesai<strong>{{ $completedCount }}</strong></td><td>Sertifikat<strong>{{ $completedCount }}</strong></td><td>Progress Rata-rata<strong>{{ $averageProgress }}%</strong></td></tr>
    </table>

    <h2>Daftar Kelas dan Progress</h2>
    <table>
        <thead><tr><th>No</th><th>Nama Kelas</th><th>Kategori</th><th>Status</th><th>Progress</th><th>Batch</th><th>Tanggal Mulai</th></tr></thead>
        <tbody>
            @forelse($classReports as $index => $report)
                <tr><td>{{ $index + 1 }}</td><td>{{ $report['kelas']->nama_kelas }}</td><td>{{ $report['kelas']->kategori ?: '-' }}</td><td class="status">{{ $report['status'] }}</td><td>{{ $report['progress'] }}%</td><td>{{ $report['batch']->nama_batch ?? '-' }}</td><td>{{ $report['joined_at']?->format('d M Y') ?: '-' }}</td></tr>
            @empty
                <tr><td colspan="7">Belum ada data kelas.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Equip Discipleship Learning Management System</div>
</body>
</html>
