<!doctype html>
<html lang="id"><head><meta charset="UTF-8"><style>
*{box-sizing:border-box}body{font-family:DejaVu Sans,sans-serif;color:#263238;font-size:10px}.header{text-align:center;border-bottom:3px solid #344767;padding-bottom:12px;margin-bottom:16px}.header h1{font-size:18px;margin:0 0 4px;color:#344767}.header p{margin:0;color:#67748e}.info{width:100%;border-collapse:collapse;background:#f4f6f8;margin-bottom:16px}.info td{padding:7px 9px}.label{font-weight:bold;color:#344767;width:125px}.score{width:100%;border-collapse:collapse;margin-bottom:16px}.score td{border:1px solid #e1e5ea;text-align:center;padding:10px}.number{font-size:20px;font-weight:bold;color:#344767}.caption{font-size:8px;color:#67748e}.answer{border:1px solid #e1e5ea;border-left:4px solid #5e72e4;margin-bottom:10px;padding:9px}.answer-title{font-weight:bold;margin-bottom:6px}.answer-text{color:#4a5568}.footer{margin-top:18px;border-top:1px solid #ddd;padding-top:8px;text-align:center;color:#8392ab;font-size:8px}
</style></head><body>
<div class="header"><h1>Hasil Quiz Peserta</h1><p>Equip Discipleship Learning Management System</p></div>
<table class="info"><tr><td class="label">Peserta</td><td>{{ $participant->nama_lengkap ?? $participant->name }}</td><td class="label">Email</td><td>{{ $participant->email }}</td></tr><tr><td class="label">Kelas</td><td>{{ $quiz->sesi->kelas->nama_kelas }}</td><td class="label">Sesi</td><td>Sesi {{ $quiz->sesi->urutan }} - {{ $quiz->sesi->judul }}</td></tr><tr><td class="label">Quiz</td><td>{{ $quiz->judul }}</td><td class="label">Dikirim</td><td>{{ $attempt->submitted_at?->format('d M Y H:i') }}</td></tr></table>
<table class="score">
	<tr>
		<td><div class="number">{{ $attempt->score !== null ? $attempt->score : '-' }} / {{ $maxScore }}</div><div class="caption">NILAI</div></td>
		<td><div class="number">{{ $percentage }}%</div><div class="caption">PERSENTASE</div></td>
		<td>
			<div class="number">
				@if($attempt->status === 'needs_review')
					Review Esai
				@elseif($passed)
					Lulus
				@else
					Belum Lulus
				@endif
			</div>
			<div class="caption">STATUS</div>
		</td>
	</tr>
</table>

@foreach($attempt->answers as $index => $answer)
	<div class="answer">
		<div class="answer-title">
			{{ $index + 1 }}. {{ $answer->question->question }}
			({{ $answer->points_awarded !== null ? $answer->points_awarded . ' / ' . $answer->question->points : 'Menunggu review' }})
		</div>
		<div class="answer-text">{{ $answer->option?->option_text ?? $answer->answer_text ?? 'Tidak dijawab' }}</div>
	</div>
@endforeach
<div class="footer">Dicetak pada {{ now()->format('d F Y H:i') }}</div>
</body></html>
