<x-app-layout>
    @section('title', 'Laporan Hasil Quiz')

    <div class="container-fluid py-4">
        <div class="card bg-gradient-dark mb-4">
            <div class="card-body p-4 text-white">
                <h4 class="text-white mb-1"><i class="fas fa-clipboard-check me-2"></i>Laporan Hasil Quiz</h4>
                <p class="mb-0 text-sm opacity-8">Pantau nilai dan jawaban peserta.</p>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger text-white">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.quiz-reports.index') }}">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-4"><label class="form-label text-xs font-weight-bold">Kelas</label><select name="kelas_id" class="form-select" onchange="this.form.submit()"><option value="">Pilih Kelas</option>@foreach($kelases as $kelas)<option value="{{ $kelas->id }}" @selected($selectedKelas?->id === $kelas->id)>{{ $kelas->nama_kelas }}</option>@endforeach</select></div>
                        <div class="col-lg-3"><label class="form-label text-xs font-weight-bold">Sesi</label><select name="sesi_id" class="form-select" onchange="this.form.submit()" {{ !$selectedKelas ? 'disabled' : '' }}><option value="">Pilih Sesi</option>@foreach($sesis as $sesi)<option value="{{ $sesi->id }}" @selected($selectedSesi?->id === $sesi->id)>Sesi {{ $sesi->urutan }} - {{ $sesi->judul }}</option>@endforeach</select></div>
                        <div class="col-lg-3"><label class="form-label text-xs font-weight-bold">Batch</label><select name="batch_id" class="form-select" onchange="this.form.submit()" {{ !$selectedKelas ? 'disabled' : '' }}><option value="">Pilih Batch</option>@foreach($batches as $batch)<option value="{{ $batch->id }}" @selected($selectedBatch?->id === $batch->id)>{{ $batch->nama_batch }}</option>@endforeach</select></div>
                        @if($quiz && $selectedBatch)<div class="col-lg-2"><a href="{{ route('admin.quiz-reports.pdf', request()->query()) }}" class="btn btn-danger w-100 mb-0"><i class="fas fa-file-pdf me-2"></i>Export PDF</a></div>@endif
                    </div>
                </form>
            </div>
        </div>

        @if($quiz && $selectedBatch)
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-3"><div class="card"><div class="card-body"><span class="text-sm text-secondary">Peserta</span><h4 class="mb-0">{{ $summary['participants'] }}</h4></div></div></div>
                <div class="col-xl-3 col-sm-6 mb-3"><div class="card"><div class="card-body"><span class="text-sm text-secondary">Sudah Mengumpulkan</span><h4 class="mb-0 text-info">{{ $summary['submitted'] }}</h4></div></div></div>
                <div class="col-xl-3 col-sm-6 mb-3"><div class="card"><div class="card-body"><span class="text-sm text-secondary">Rata-rata Nilai</span><h4 class="mb-0 text-primary">{{ $summary['average'] }} / {{ $summary['max_score'] }}</h4></div></div></div>
                <div class="col-xl-3 col-sm-6 mb-3"><div class="card"><div class="card-body"><span class="text-sm text-secondary">Lulus</span><h4 class="mb-0 text-success">{{ $summary['passed'] }}</h4><small class="text-warning">{{ $summary['needs_review'] }} perlu review esai</small></div></div></div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-transparent border-bottom"><h6 class="mb-1">{{ $quiz->judul }}</h6><p class="text-sm text-secondary mb-0">{{ $selectedKelas->nama_kelas }} &middot; Sesi {{ $selectedSesi->urutan }} &middot; {{ $selectedBatch->nama_batch }}</p></div>
                <div class="table-responsive"><table class="table align-items-center mb-0"><thead class="bg-light"><tr><th class="ps-4">Peserta</th><th>Status</th><th class="text-center">Nilai</th><th class="text-center">Persentase</th><th>Pengumpulan</th><th class="text-end pe-4">Detail / Link</th></tr></thead><tbody>
                    @forelse($reports as $report)
                        @php
                            $attempt = $report['attempt'];
                        @endphp
                        <tr>
                            <td class="ps-4"><strong>{{ $report['user']->nama_lengkap ?? $report['user']->name }}</strong><div class="text-xs text-secondary">{{ $report['user']->email }}</div></td>
                            <td>@if(!$attempt)<span class="badge bg-secondary">Belum mengerjakan</span>@elseif($attempt->status === 'needs_review')<span class="badge bg-warning">Perlu review</span>@elseif($report['passed'])<span class="badge bg-success">Lulus</span>@else<span class="badge bg-danger">Belum lulus</span>@endif</td>
                            <td class="text-center">{{ $report['score'] !== null ? $report['score'] . ' / ' . $summary['max_score'] : '-' }}</td>
                            <td class="text-center">{{ $attempt ? $report['percentage'] . '%' : '-' }}</td>
                            <td>{{ $attempt?->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                            <td class="text-end pe-4">
                                @if($attempt)
                                    @php $shareUrl = route('quiz-results.preview', $attempt->share_token); @endphp
                                    <div class="d-flex justify-content-end align-items-center gap-1"><button type="button" class="btn btn-link text-primary px-1 mb-0" data-bs-toggle="modal" data-bs-target="#attempt{{ $attempt->id }}">Detail</button><button type="button" class="btn btn-outline-secondary btn-sm mb-0 copy-result-link" data-url="{{ $shareUrl }}" title="Copy link"><i class="fas fa-copy"></i></button></div>
                                    <input type="text" readonly value="{{ $shareUrl }}" class="form-control form-control-sm mt-1" onclick="this.select()">
                                @else
                                    <span class="text-secondary text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-secondary">Tidak ada peserta pada batch ini.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>

            @foreach($reports as $report)
                @if($report['attempt'])
                    @php
                        $attempt = $report['attempt'];
                        $maxScore = $summary['max_score'];
                        $percentage = $maxScore > 0 && $report['score'] !== null ? round(($report['score'] / $maxScore) * 100) : 0;
                        $shareUrl = route('quiz-results.preview', $attempt->share_token);
                    @endphp
                    <div class="modal fade" id="attempt{{ $attempt->id }}" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
                        <div class="modal-header bg-gradient-dark text-white"><div><h5 class="modal-title text-white mb-1">Hasil Quiz Peserta</h5><p class="text-white text-sm mb-0 opacity-8">{{ $quiz->judul }} &middot; {{ $selectedKelas->nama_kelas }}</p></div><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                        <div class="modal-body p-4">
                            <div class="card border-0 shadow-sm mb-4"><div class="card-body p-3"><div class="row align-items-center"><div class="col-md-7"><span class="text-xs text-secondary text-uppercase font-weight-bold">Peserta</span><h4 class="mb-1">{{ $report['user']->nama_lengkap ?? $report['user']->name }}</h4><p class="text-sm text-secondary mb-0">{{ $report['user']->email }}</p></div><div class="col-md-5 text-md-end mt-3 mt-md-0"><span class="text-xs text-secondary text-uppercase font-weight-bold">Nilai</span><h2 class="mb-0 text-primary">{{ $report['score'] ?? '-' }} <small class="text-sm text-secondary">/ {{ $maxScore }}</small></h2><span class="text-sm text-secondary">{{ $percentage }}%</span></div></div><hr><div class="d-flex justify-content-between align-items-center flex-wrap gap-2"><span>Status: @if($attempt->status === 'needs_review')<span class="badge bg-warning">Menunggu review esai</span>@elseif($report['passed'])<span class="badge bg-success">Lulus</span>@else<span class="badge bg-danger">Belum lulus</span>@endif</span><span class="text-sm text-secondary">Dikirim {{ $attempt->submitted_at?->format('d M Y H:i') }}</span></div></div></div>
                            <h6 class="mb-3">Rincian Jawaban</h6>
                            @foreach($attempt->answers as $answerIndex => $answer)<div class="border rounded p-3 mb-3" style="border-left: 4px solid #5e72e4 !important;"><div class="d-flex justify-content-between gap-3 mb-2"><strong>{{ $answerIndex + 1 }}. {{ $answer->question->question }}</strong><span class="badge bg-light text-dark flex-shrink-0">{{ $answer->points_awarded !== null ? $answer->points_awarded . ' / ' . $answer->question->points : 'Menunggu review' }}</span></div><p class="mb-0 text-sm">{{ $answer->option?->option_text ?? $answer->answer_text ?? 'Tidak dijawab' }}</p></div>@endforeach
                        </div>
                        <div class="modal-footer justify-content-between"><button type="button" class="btn btn-light mb-0" data-bs-dismiss="modal">Tutup</button><div class="d-flex gap-2"><button type="button" class="btn btn-outline-secondary mb-0 copy-result-link" data-url="{{ $shareUrl }}"><i class="fas fa-copy me-1"></i>Copy Link</button><a href="{{ route('quiz-results.download', $attempt->share_token) }}" class="btn btn-danger mb-0"><i class="fas fa-file-pdf me-1"></i>Download PDF</a></div></div>
                    </div></div></div>
                @endif
            @endforeach
        @elseif($selectedSesi && !$quiz)
            <div class="card"><div class="card-body text-center py-5 text-secondary">Sesi ini belum memiliki quiz internal.</div></div>
        @else
            <div class="card"><div class="card-body text-center py-5 text-secondary">Pilih kelas, sesi, dan batch untuk melihat hasil quiz.</div></div>
        @endif
    </div>
</x-app-layout>

<script>
document.querySelectorAll('.copy-result-link').forEach(function (button) {
    button.addEventListener('click', function () {
        navigator.clipboard.writeText(button.dataset.url).then(function () {
            const icon = button.querySelector('i');
            if (icon) { icon.className = 'fas fa-check text-success'; setTimeout(function () { icon.className = 'fas fa-copy'; }, 1500); }
        });
    });
});
</script>
