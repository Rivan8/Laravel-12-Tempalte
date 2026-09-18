@extends('layouts.app')

@section('title', 'Belajar: ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Video Player Section -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card shadow-lg h-100">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-weight-bolder mb-0">{{ $kelas->nama_kelas }}</h4>
                        <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                            <span class="badge bg-gradient-success">{{ $activeSesi ? 'Sesi ' . $activeSesi->urutan : 'Belum tersedia' }}</span>
                            @if($activeSesi && $activeSesi->tanggal_pelaksanaan)
                                <span class="text-xs text-primary fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i>{{ $activeSesi->tanggal_pelaksanaan->translatedFormat('l, d F Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- 16:9 aspect ratio container -->
                    <div class="ratio ratio-16x9 bg-dark border-radius-lg shadow-sm overflow-hidden mb-4" style="position: relative; padding-bottom: 56.25%; height: 0;">
                        @if($activeMateri)
                            <!-- YouTube Player API Container -->
                            <div id="youtube-player" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" class="border-radius-lg"></div>
                        @else
                            <!-- Empty State Placeholder -->
                            <div class="d-flex align-items-center justify-content-center flex-column" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #1c1c1c;">
                                <i class="fas fa-video-slash fa-3x text-secondary mb-3"></i>
                                <h5 class="text-white">Materi Belum Tersedia</h5>
                                <p class="text-secondary text-sm text-center px-4">Admin gereja akan segera mengunggah video untuk kelas ini. Mohon bersabar menunggu jadwal tayang.</p>
                            </div>
                        @endif
                    </div>

                    <h5>{{ $activeMateri ? $activeMateri->judul : 'Sesi Belum Dijadwalkan' }}</h5>
                    @if($activeMateri && $activeMateri->pembicara)
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon icon-shape icon-xs bg-gradient-primary shadow text-center border-radius-sm d-flex align-items-center justify-content-center me-2">
                            <i class="fas fa-user-tie text-white" style="font-size: 0.6rem;"></i>
                        </div>
                        <span class="text-sm font-weight-bold text-dark">{{ $activeMateri->pembicara }}</span>
                        <span class="badge bg-gradient-light text-dark ms-2 border-radius-sm" style="font-size: 0.65rem;">Pengajar</span>
                    </div>
                    @endif
                    <p class="text-sm text-secondary">
                        {{ $activeMateri ? $activeMateri->deskripsi : 'Deksripsi dan penjabaran sesi kurikulum belum tersedia untuk saat ini.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar Playlist / Silabus -->
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm h-100">
                <div class="card-header pb-0 border-bottom">
                    <h6 class="mb-3">Silabus & Materi Kelas</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                        @if(isset($sessionList))
                            @forelse($sessionList as $session)
                                <li class="list-group-item py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <span class="badge bg-gradient-dark me-1">Sesi {{ $session->urutan }}</span>
                                            <span class="text-sm font-weight-bold">{{ $session->judul }}</span>
                                            @if($session->tanggal_pelaksanaan)
                                                <div class="text-xs text-primary mt-1"><i class="fas fa-calendar-alt me-1"></i>{{ $session->tanggal_pelaksanaan->translatedFormat('l, d F Y') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach($session->materi as $video)
                                        @php $isActive = $activeMateri && $video->id === $activeMateri->id; @endphp
                                        <a href="{{ $video->is_locked ? '#' : route('kelas.belajar', ['id' => $kelas->id, 'materi_id' => $video->id]) }}" data-url="{{ route('kelas.belajar', ['id' => $kelas->id, 'materi_id' => $video->id]) }}" class="text-decoration-none d-block {{ $video->is_locked ? 'pe-none' : '' }}">
                                            <div class="d-flex align-items-center py-2 ps-2 {{ $isActive ? 'bg-gray-100 border-start border-3 border-primary' : '' }}">
                                                <div class="icon icon-shape icon-xs shadow border-radius-sm {{ $isActive ? 'bg-gradient-primary' : ($video->is_locked ? 'bg-light' : 'bg-gradient-secondary') }} text-center me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-{{ $video->is_locked ? 'lock' : ($video->is_completed ? 'check' : 'play') }} {{ $video->is_locked ? 'text-secondary' : 'text-white' }}" style="font-size: 0.6rem;"></i>
                                                </div>
                                                <div class="text-sm {{ $video->is_locked ? 'text-secondary opacity-6' : 'text-dark' }}">{{ $video->urutan }}. {{ $video->judul }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                    @if($session->materi->isEmpty())
                                        <div class="text-xs text-secondary ps-2">Video sesi belum tersedia.</div>
                                    @endif
                                    @if($session->quiz_unlocked)
                                        <div class="mt-3 pt-3 border-top">
                                            <a href="{{ $session->quiz ? route('quiz.show', [$kelas->id, $session->id]) : $session->link_quiz }}" @if(!$session->quiz) target="_blank" @endif class="btn btn-success btn-sm w-100 mb-0">
                                                <i class="fas fa-clipboard-check me-1"></i>Kuis Sesi {{ $session->urutan }}
                                            </a>
                                        </div>
                                    @elseif($session->link_quiz)
                                        <div class="mt-3 pt-3 border-top text-center">
                                            <span class="text-xs text-secondary"><i class="fas fa-lock me-1"></i>Kuis terkunci sampai semua video selesai</span>
                                        </div>
                                    @endif
                                </li>
                            @empty
                                <p class="text-center py-4 text-sm text-primary mb-0">Sesi pembelajaran segera ditambahkan.</p>
                            @endforelse
                        @endif
                    </ul>
                </div>
                <!-- Action Button Quiz Akhir -->
                @if($isAllCompleted && !empty($kelas->link_quiz))
                <div class="card-footer text-center pt-4 border-top">
                    <a href="{{ $kelas->link_quiz }}" target="_blank" class="btn bg-gradient-success w-100 mb-2 shadow"><i class="fas fa-award me-2"></i>Kuis Akhir Kelas Terbuka</a>
                    <small class="text-xs text-success font-weight-bolder">Selamat! Semua video kelas telah selesai ditonton.</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($activeMateri)
<!-- Script YouTube IFrame API -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    var player;
    var isCompleted = {{ $activeMateri->is_completed ? 'true' : 'false' }};
    var hasNotified = false;

    function onYouTubeIframeAPIReady() {
        var videoUrl = "{{ $activeMateri->video_url }}";
        var videoId = "";

        // Ekstraktor ID Cerdas
        if (videoUrl.includes("embed/")) {
            videoId = videoUrl.split("embed/")[1].split("?")[0];
        } else if (videoUrl.includes("watch?v=")) {
            videoId = videoUrl.split("watch?v=")[1].split("&")[0];
        } else if (videoUrl.includes("youtu.be/")) {
            videoId = videoUrl.split("youtu.be/")[1].split("?")[0];
        }

        if(videoId) {
            player = new YT.Player('youtube-player', {
                videoId: videoId,
                playerVars: {
                    'rel': 0,
                    'modestbranding': 1,
                    'playsinline': 1
                },
                events: {
                    'onReady': onPlayerReady
                }
            });
        }
    }

    function onPlayerReady(event) {
        // Cek progress setiap 3 detik
        setInterval(checkProgress, 3000);
    }

    function checkProgress() {
        if (!player || isCompleted || hasNotified) return;

        var duration = player.getDuration();
        var currentTime = player.getCurrentTime();

        // Jika durasi valid dan tontonan melebihi 80% (0.8)
        if (duration > 0 && (currentTime / duration) >= 0.8) {
            isCompleted = true;
            hasNotified = true;

            // Diam-diam lempar laporan ke Server Laravel
            fetch("{{ route('materi.complete', $activeMateri->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      // Cari link Sesi terkunci pertama di sidebar
                      let nextLockedLink = document.querySelector('.pe-none');
                      if (nextLockedLink && nextLockedLink.hasAttribute('data-url')) {
                          nextLockedLink.href = nextLockedLink.getAttribute('data-url');
                          nextLockedLink.classList.remove('pe-none');

                          // Ubah ikon gembok menjadi ikon play (warna hijau)
                          let iconDiv = nextLockedLink.querySelector('.icon-shape');
                          if (iconDiv) {
                              iconDiv.classList.remove('bg-light', 'bg-gradient-secondary');
                              iconDiv.classList.add('bg-gradient-success');
                              iconDiv.innerHTML = '<i class="fas fa-play text-white opacity-10" style="font-size: 0.7rem;"></i>';
                          }

                          // Ubah teks "Terkunci" menjadi Badge Pop-up Merah
                          let titleSpan = nextLockedLink.querySelector('h6');
                          if (titleSpan) {
                              titleSpan.classList.remove('opacity-6');
                          }
                          let statusSpan = nextLockedLink.querySelector('span.text-xs');
                          if (statusSpan) {
                              statusSpan.innerHTML = '<span class="badge bg-danger border-radius-sm">Terbuka</span>';
                              statusSpan.classList.remove('text-secondary', 'opacity-6', 'text-primary');
                          }
                      }

                      // Beri tahu user secara halus (tanpa interupsi alert)
                      console.log('Sesi berikutnya berhasil dibuka!');
                  }
              }).catch(err => console.error(err));
        }
    }
</script>
@endif

@endsection
