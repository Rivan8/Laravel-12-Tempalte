@extends('layouts.app')

@section('title', $quiz->judul)

@section('content')
<div class="container py-4" style="max-width: 900px;">
    @if(session('success'))<div class="alert alert-success text-white">{{ session('success') }}</div>@endif
    @if($latestAttempt)
        <div class="alert alert-info">Percobaan terakhir: <strong>{{ number_format($latestAttempt->score, 0) }}</strong> poin. Status: <strong>{{ $latestAttempt->status === 'needs_review' ? 'Menunggu pemeriksaan esai' : 'Dinilai otomatis' }}</strong>.</div>
    @endif
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <a href="{{ route('kelas.belajar', $sesi->kelas_id) }}" class="text-secondary text-sm"><i class="fas fa-arrow-left me-1"></i>Kembali ke pembelajaran</a>
            <span class="badge bg-gradient-primary d-block mt-3 mb-2" style="width: fit-content;">Sesi {{ $sesi->urutan }}</span>
            <h3 class="mb-2">{{ $quiz->judul }}</h3>
            <p class="text-secondary mb-0">{{ $quiz->deskripsi ?: 'Jawab semua pertanyaan dengan teliti.' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('quiz.submit', [$sesi->kelas_id, $sesi->id]) }}">
        @csrf
        @foreach($quiz->questions as $index => $question)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between gap-3 mb-3"><h5 class="mb-0">{{ $index + 1 }}. {{ $question->question }}</h5><span class="badge bg-light text-dark flex-shrink-0">{{ $question->points }} poin</span></div>
                    @if($question->type === 'multiple_choice')
                        @foreach($question->options as $option)
                            <label class="d-flex align-items-center gap-2 border rounded p-3 mb-2" style="cursor:pointer;"><input type="radio" name="answers[{{ $question->id }}][option_id]" value="{{ $option->id }}" required><span>{{ $option->option_text }}</span></label>
                        @endforeach
                    @else
                        <textarea name="answers[{{ $question->id }}][text]" class="form-control" rows="5" placeholder="Tulis jawaban Anda..." required></textarea>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-end"><button class="btn bg-gradient-primary"><i class="fas fa-paper-plane me-2"></i>Kirim Jawaban</button></div>
    </form>
</div>
@endsection
