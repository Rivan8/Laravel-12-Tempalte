@extends('layouts.app')

@section('title', 'Builder Quiz: ' . $sesi->judul)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom">
                    <a href="{{ route('admin.sesi.index', $kelas->id) }}" class="text-secondary text-sm"><i class="fas fa-arrow-left me-1"></i>Kembali ke Kelola Sesi</a>
                    <h5 class="mt-3 mb-1">Builder Quiz</h5>
                    <p class="text-sm text-secondary mb-0">{{ $kelas->nama_kelas }} &middot; Sesi {{ $sesi->urutan }}: {{ $sesi->judul }}</p>
                </div>
                <form action="{{ route('admin.quiz.save', [$kelas->id, $sesi->id]) }}" method="POST" id="quizForm">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger text-white">{{ $errors->first() }}</div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-md-8 mb-3"><label class="form-label font-weight-bold">Judul Quiz</label><input name="judul" class="form-control" value="{{ old('judul', $sesi->quiz?->judul ?? 'Quiz Sesi ' . $sesi->urutan) }}" required></div>
                            <div class="col-md-4 mb-3"><label class="form-label font-weight-bold">Nilai Minimum Lulus</label><input type="number" name="passing_score" class="form-control" min="0" value="{{ old('passing_score', $sesi->quiz?->passing_score ?? 0) }}" required><small class="text-secondary">Gunakan 0 jika tidak ada batas lulus.</small></div>
                            <div class="col-12"><label class="form-label font-weight-bold">Deskripsi Quiz</label><textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $sesi->quiz?->deskripsi) }}</textarea></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div><h6 class="mb-1">Daftar Pertanyaan</h6><span class="text-xs text-secondary">Pilihan ganda dinilai otomatis, esai menunggu pemeriksaan admin.</span></div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-0" id="addQuestion"><i class="fas fa-plus me-1"></i>Tambah Pertanyaan</button>
                        </div>
                        <div id="questions"></div>
                        <div id="emptyQuestions" class="text-center py-5 border rounded text-secondary">Belum ada pertanyaan. Tambahkan pertanyaan pertama.</div>
                    </div>
                    <div class="card-footer bg-transparent border-top d-flex justify-content-end gap-2"><a href="{{ route('admin.sesi.index', $kelas->id) }}" class="btn btn-outline-secondary mb-0">Batal</a><button class="btn bg-gradient-primary mb-0"><i class="fas fa-save me-1"></i>Simpan Quiz</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<template id="questionTemplate">
    <div class="question-card border rounded p-3 mb-3 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3"><span class="question-number badge bg-gradient-primary">Pertanyaan</span><button type="button" class="btn btn-link text-danger p-0 remove-question"><i class="far fa-trash-alt me-1"></i>Hapus</button></div>
        <div class="row">
            <div class="col-md-8 mb-3"><label class="form-label text-sm font-weight-bold">Pertanyaan</label><textarea class="form-control question-text" rows="2" required></textarea></div>
            <div class="col-md-2 mb-3"><label class="form-label text-sm font-weight-bold">Tipe</label><select class="form-select question-type"><option value="multiple_choice">Pilihan Ganda</option><option value="essay">Esai</option></select></div>
            <div class="col-md-2 mb-3"><label class="form-label text-sm font-weight-bold">Nilai</label><input type="number" class="form-control question-points" min="1" value="1" required></div>
        </div>
        <div class="options-area"></div>
    </div>
</template>

<template id="optionTemplate"><div class="input-group mb-2 option-row"><span class="input-group-text"><input type="radio" class="correct-option" title="Jawaban benar"></span><input type="text" class="form-control option-text" placeholder="Tulis pilihan jawaban"><button type="button" class="btn btn-outline-danger remove-option"><i class="fas fa-times"></i></button></div></template>

<script>
const questionRoot = document.getElementById('questions');
const emptyQuestions = document.getElementById('emptyQuestions');
let questionIndex = 0;

function refreshQuestions() {
    emptyQuestions.style.display = questionRoot.children.length ? 'none' : 'block';
    [...questionRoot.children].forEach((card, index) => {
        card.querySelector('.question-number').textContent = `Pertanyaan ${index + 1}`;
        card.querySelector('.question-text').name = `questions[${index}][text]`;
        card.querySelector('.question-type').name = `questions[${index}][type]`;
        card.querySelector('.question-points').name = `questions[${index}][points]`;
        card.querySelectorAll('.option-text').forEach((input, optionIndex) => input.name = `questions[${index}][options][${optionIndex}][text]`);
        card.querySelectorAll('.correct-option').forEach((input, optionIndex) => {
            input.name = `questions[${index}][correct_index]`;
            input.value = optionIndex;
        });
    });
}

function addOption(area, text = '', correct = false) {
    const option = document.getElementById('optionTemplate').content.cloneNode(true);
    const row = option.querySelector('.option-row');
    row.querySelector('.option-text').value = text;
    row.querySelector('.correct-option').checked = correct;
    row.querySelector('.remove-option').addEventListener('click', () => { row.remove(); refreshQuestions(); });
    area.appendChild(option);
}

function addQuestion(data = null) {
    const card = document.getElementById('questionTemplate').content.cloneNode(true).firstElementChild;
    card.querySelector('.question-text').value = data?.question || '';
    card.querySelector('.question-type').value = data?.type || 'multiple_choice';
    card.querySelector('.question-points').value = data?.points || 1;
    const area = card.querySelector('.options-area');
    const renderOptions = () => {
        area.innerHTML = '';
        if (card.querySelector('.question-type').value === 'multiple_choice') {
            const options = data?.options || [{ option_text: '' }, { option_text: '' }];
            options.forEach((option, index) => addOption(area, option.option_text, option.is_correct));
            const button = document.createElement('button');
            button.type = 'button'; button.className = 'btn btn-outline-secondary btn-sm add-option mb-2'; button.innerHTML = '<i class="fas fa-plus me-1"></i>Tambah Opsi';
            button.addEventListener('click', () => addOption(area)); area.appendChild(button);
        } else {
            area.innerHTML = '<div class="text-xs text-secondary border-start border-3 border-info ps-2 mb-2">Jawaban esai akan diperiksa dan diberi nilai oleh admin.</div>';
        }
        refreshQuestions();
    };
    card.querySelector('.question-type').addEventListener('change', () => { data = null; renderOptions(); });
    card.querySelector('.remove-question').addEventListener('click', () => { card.remove(); refreshQuestions(); });
    questionRoot.appendChild(card);
    renderOptions();
}

document.getElementById('addQuestion').addEventListener('click', () => addQuestion());
@if($sesi->quiz && $sesi->quiz->questions->count())
    @foreach($sesi->quiz->questions as $question)
        addQuestion(@json($question));
    @endforeach
@else
    addQuestion();
@endif
</script>
@endsection
