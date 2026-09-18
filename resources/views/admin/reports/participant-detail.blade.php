<x-app-layout>
    @section('title', 'Laporan Peserta Detail')

    <style>
    </style>

    <div class="container-fluid py-4 participant-detail-report">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Laporan Detail Peserta</h4>
                <p class="text-sm text-secondary mb-0">Ringkasan kelas dan progress belajar peserta.</p>
            </div>
            @if($selectedParticipant)
                <a class="btn btn-outline-danger mb-0" href="{{ route('admin.reports.participant-detail.pdf', request()->query()) }}">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
            @endif
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.participant-detail') }}" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label text-sm font-weight-bold" for="user_id">Pilih Peserta</label>
                        <select class="form-select" name="user_id" id="user_id" onchange="this.form.submit()">
                            <option value="">Pilih peserta</option>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}" @selected($selectedParticipant?->id === $participant->id)>{{ $participant->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm font-weight-bold" for="kelas_id">Pilih Kelas</label>
                        <select class="form-select" name="kelas_id" id="kelas_id">
                            <option value="">Semua Kelas</option>
                            @foreach($kelases as $kelas)
                                <option value="{{ $kelas->id }}" @selected($selectedKelas?->id === $kelas->id)>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn bg-gradient-success mb-0" type="submit">Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>

        @if($selectedParticipant)
            <div class="row g-3 mb-4">
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-3">{{ $selectedParticipant->nama_lengkap }}</h5>
                            <p class="text-sm mb-2"><strong>ID:</strong> {{ $selectedParticipant->id }}</p>
                            <p class="text-sm mb-2"><strong>Email:</strong> {{ $selectedParticipant->email }}</p>
                            <p class="text-sm mb-0"><strong>Telepon:</strong> {{ $selectedParticipant->no_hp ?: '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><p class="text-sm mb-1">Total Kelas Diikuti</p><h3>{{ $classReports->count() }}</h3></div></div></div>
                <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><p class="text-sm mb-1">Total Kelas Selesai</p><h3>{{ $completedCount }}</h3></div></div></div>
                <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><p class="text-sm mb-1">Sertifikat</p><h3>{{ $completedCount }}</h3></div></div></div>
                <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><p class="text-sm mb-1">Progress Rata-rata</p><h3>{{ $averageProgress }}%</h3></div></div></div>
            </div>

            <div class="card">
                <div class="card-header pb-0"><h5>Daftar Kelas &amp; Progress {{ $selectedParticipant->nama_lengkap }}</h5></div>
                <div class="card-body px-0 pt-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead><tr><th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th><th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nama Kelas</th><th class="text-uppercase text-secondary text-xxs font-weight-bolder">Kategori</th><th class="text-uppercase text-secondary text-xxs font-weight-bolder">Status</th><th class="text-uppercase text-secondary text-xxs font-weight-bolder">Progress</th><th class="text-uppercase text-secondary text-xxs font-weight-bolder">Tanggal Mulai</th></tr></thead>
                            <tbody>
                                @forelse($classReports as $index => $report)
                                    <tr><td class="ps-4">{{ $index + 1 }}</td><td>{{ $report['kelas']->nama_kelas }}</td><td>{{ $report['kelas']->kategori ?: '-' }}</td><td><span class="badge bg-{{ $report['status'] === 'Selesai' ? 'success' : ($report['status'] === 'Sedang Berjalan' ? 'warning' : 'secondary') }}">{{ $report['status'] }}</span></td><td style="min-width: 160px"><div class="d-flex align-items-center gap-2"><div class="progress w-75"><div class="progress-bar bg-info" style="width: {{ $report['progress'] }}%"></div></div><span class="text-sm">{{ $report['progress'] }}%</span></div></td><td>{{ $report['joined_at']?->format('d M Y') ?: '-' }}</td></tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4 text-secondary">Belum ada data kelas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card"><div class="card-body text-center py-5 text-secondary">Pilih peserta untuk melihat laporan detail.</div></div>
        @endif
    </div>
</x-app-layout>
