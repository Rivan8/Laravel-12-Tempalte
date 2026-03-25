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
                        <span class="badge bg-gradient-success">Sesi {{ $activeMateri ? $activeMateri->urutan : '?' }}</span>
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
                        @if(isset($materiList))
                            @forelse($materiList as $sesi)
                                @php
                                    $isActive = $activeMateri && $sesi->id === $activeMateri->id;
                                    $isLocked = $sesi->is_locked;
                                    // Pointer-events-none disables clicking if locked
                                @endphp
                                <a href="{{ $isLocked ? '#' : route('kelas.belajar', ['id' => $kelas->id, 'materi_id' => $sesi->id]) }}" data-url="{{ route('kelas.belajar', ['id' => $kelas->id, 'materi_id' => $sesi->id]) }}" class="text-decoration-none {{ $isLocked ? 'pe-none' : '' }}">
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 {{ $isActive ? 'bg-gray-100 border-start border-4 border-primary fixed-style' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm shadow border-radius-sm {{ $isActive ? 'bg-gradient-primary' : ($isLocked ? 'bg-light' : 'bg-gradient-secondary') }} text-center me-3 d-flex align-items-center justify-content-center">
                                                @if($isLocked)
                                                    <i class="fas fa-lock text-secondary opacity-6" style="font-size: 0.7rem;"></i>
                                                @elseif($isActive)
                                                    <i class="fas fa-play text-white opacity-10" style="font-size: 0.7rem;"></i>
                                                @else
                                                    <i class="fas fa-check text-white opacity-10" style="font-size: 0.7rem;"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="text-sm {{ $isActive ? 'text-dark font-weight-bold' : ($isLocked ? 'text-secondary opacity-6' : 'text-secondary') }} mb-0">{{ $sesi->urutan }}. {{ $sesi->judul }}</h6>
                                                @if($isLocked)
                                                    <span class="text-xs text-secondary opacity-6">Terkunci</span>
                                                @elseif($isActive)
                                                    <span class="text-xs text-primary font-weight-bold opacity-8">Sedang ditonton</span>
                                                @else
                                                    <span class="text-xs text-success font-weight-bold opacity-8"><i class="fas fa-check-double me-1"></i>Selesai</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @empty
                                <p class="text-center py-4 text-sm text-primary mb-0">Video sesi segera ditambahkan.</p>
                            @endforelse
                        @endif
                    </ul>
                </div>
                <!-- Action Button Quiz Akhir -->
                <div class="card-footer text-center pt-4 border-top">
                    @if(isset($isAllCompleted) && $isAllCompleted && isset($materiList) && $materiList->count() > 0)
                        <a href="#" class="btn bg-gradient-success w-100 mb-2 shadow position-relative overflow-hidden">
                            <span class="position-relative z-index-1"><i class="fas fa-award me-2"></i> Kuis Ujian Akhir Terbuka</span>
                        </a>
                        <small class="text-xs text-success font-weight-bolder">Selamat! Anda berhak mengikuti ujian ini.</small>
                    @else
                        <button class="btn btn-light w-100 mb-2 shadow-none text-secondary" disabled>
                            <i class="fas fa-lock me-2"></i> Kuis Ujian Akhir Kelas
                        </button>
                        <small class="text-xs text-secondary">Selesaikan seluruh tontonan materi Sesi (80%) di atas terlebih dahulu untuk membuka Ujian Kuis.</small>
                    @endif
                </div>
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
