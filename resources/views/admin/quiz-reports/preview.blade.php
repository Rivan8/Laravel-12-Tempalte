<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Quiz - {{ $participant->nama_lengkap ?? $participant->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nucleo-svg.css') }}">
    <link rel="stylesheet" href="{{ asset('css/soft-ui-dashboard.css') }}">
    <style>
        body { background: #f5f7fb; }
        .answer-card { border-left: 4px solid #5e72e4; }
        .result-score { font-size: 2.5rem; line-height: 1; }
    </style>
</head>
<body>
<div class="container py-4" style="max-width: 900px;">
    <div class="card bg-gradient-dark mb-4"><div class="card-body p-4 text-white">
        <p class="text-white text-sm mb-2 opacity-8">Equip Discipleship</p>
        <h2 class="text-white mb-1">Hasil Quiz Peserta</h2>
        <p class="text-white mb-0 opacity-8">{{ $quiz->sesi->kelas->nama_kelas }} &middot; Sesi {{ $quiz->sesi->urutan }} - {{ $quiz->sesi->judul }}</p>
    </div></div>

    <div class="card shadow-sm border-0 mb-4"><div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div><span class="text-xs text-secondary text-uppercase font-weight-bold">Peserta</span><h4 class="mb-1">{{ $participant->nama_lengkap ?? $participant->name }}</h4><p class="text-sm text-secondary mb-0">{{ $participant->email }}</p></div>
            <div class="text-md-end"><span class="text-xs text-secondary text-uppercase font-weight-bold">Nilai</span><div class="result-score font-weight-bolder text-primary">{{ $attempt->score !== null ? $attempt->score : '-' }}<small class="text-sm text-secondary"> / {{ $maxScore }}</small></div><span class="text-sm text-secondary">{{ $percentage }}%</span></div>
        </div>
        <hr>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2"><div><span class="text-sm text-secondary">Status:</span> @if($attempt->status === 'needs_review')<span class="badge bg-warning">Menunggu review esai</span>@elseif($passed)<span class="badge bg-success">Lulus</span>@else<span class="badge bg-danger">Belum lulus</span>@endif</div><span class="text-sm text-secondary">Dikirim {{ $attempt->submitted_at?->format('d M Y H:i') }}</span></div>
    </div></div>

    <div class="card shadow-sm border-0"><div class="card-header bg-transparent border-bottom"><h5 class="mb-1">{{ $quiz->judul }}</h5><p class="text-sm text-secondary mb-0">Rincian jawaban peserta</p></div><div class="card-body p-4">
        @foreach($attempt->answers as $index => $answer)
            <div class="answer-card border rounded p-3 mb-3"><div class="d-flex justify-content-between gap-3 mb-2"><strong>{{ $index + 1 }}. {{ $answer->question->question }}</strong><span class="badge bg-light text-dark flex-shrink-0">{{ $answer->points_awarded !== null ? $answer->points_awarded . ' / ' . $answer->question->points : 'Menunggu review' }}</span></div><p class="mb-0 text-sm">{{ $answer->option?->option_text ?? $answer->answer_text ?? 'Tidak dijawab' }}</p></div>
        @endforeach
    </div></div>

    <div class="text-center mt-4"><a href="{{ route('quiz-results.download', $attempt->share_token) }}" class="btn btn-danger"><i class="fas fa-file-pdf me-2"></i>Download Hasil PDF</a></div>
</div>
</body>
</html>
