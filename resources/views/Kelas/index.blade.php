@extends('layouts.app')

@section('title', 'Daftar Kelas')

@push('styles')
    <link href="{{ asset('css/kelas.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="class-list-container">
        <div class="class-header">
            <div>
                <h2 class="mb-0">Daftar Kelas</h2>
                <p class="text-sm mb-0">Pilih kelas yang ingin Anda pelajari hari ini.</p>
            </div>
            <div class="class-search">
                <input type="text" id="searchInput" placeholder="Cari kelas..." oninput="filterCards()">
                <button type="button" onclick="filterCards()">Cari</button>
            </div>
        </div>

        {{-- Filter Buttons Dinamis dari Database CMS --}}
        <div class="class-filters" id="categoryFilters">
            <button class="filter-btn active shadow-sm" data-filter="all" onclick="setFilter(this)">
                <i class="fas fa-th-large me-1"></i> Semua Kelas
            </button>
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $cat)
                <button class="filter-btn shadow-sm" data-filter="{{ Str::slug($cat) }}" onclick="setFilter(this)">
                    <i class="fas fa-layer-group me-1"></i> {{ $cat }}
                </button>
                @endforeach
            @endif
        </div>

        <div class="class-grid" id="classGrid">
            @if(isset($kelases) && $kelases->count() > 0)
                @foreach($kelases as $kelas)
                <div class="class-card shadow-sm" data-category="{{ Str::slug($kelas->kategori) }}">
                    <div class="class-image" style="height: 180px; position: relative;">
                        @if($kelas->gambar)
                            <img src="{{ asset($kelas->gambar) }}" alt="{{ $kelas->nama_kelas }}" class="w-100 h-100 object-fit-cover" style="object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        @else
                            <div class="w-100 h-100 bg-gradient-info d-flex align-items-center justify-content-center" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <i class="fas fa-church text-white fa-4x opacity-5"></i>
                            </div>
                        @endif
                    </div>
                    <div class="class-info">
                        @php
                            $catStr = strtolower($kelas->kategori);
                            $badgeColor = 'bg-gradient-dark'; // default
                            
                            if(str_contains($catStr, 'new') || str_contains($catStr, 'foundation')) { $badgeColor = 'bg-gradient-success'; }
                            elseif(str_contains($catStr, 'grow') || str_contains($catStr, 'spiritual') || str_contains($catStr, 'grade')) { $badgeColor = 'bg-gradient-warning'; }
                            elseif(str_contains($catStr, 'plant')) { $badgeColor = 'bg-gradient-info'; }
                            elseif(str_contains($catStr, 'lead') || str_contains($catStr, 'disciple')) { $badgeColor = 'bg-gradient-danger'; }
                            elseif(str_contains($catStr, 'serve') || str_contains($catStr, 'volunteer')) { $badgeColor = 'bg-gradient-primary'; }
                            elseif(str_contains($catStr, 'marri')) { $badgeColor = 'bg-gradient-secondary'; }
                            else {
                                // Fallback dinamis berdasarkan panjang / karakter string
                                $gradients = ['bg-gradient-primary', 'bg-gradient-secondary', 'bg-gradient-info', 'bg-gradient-success', 'bg-gradient-warning', 'bg-gradient-danger', 'bg-gradient-dark'];
                                $badgeColor = $gradients[strlen($catStr) % count($gradients)];
                            }
                        @endphp
                        <span class="badge {{ $badgeColor }} shadow-sm mb-2 px-3 py-1 font-weight-bold text-xs" style="border-radius: 6px; letter-spacing: 0.5px;">
                            <i class="fas fa-tag me-1 opacity-8"></i> {{ mb_strtoupper($kelas->kategori) }}
                        </span>
                        <h4 class="mt-1 font-weight-bolder text-dark mb-2" style="font-size: 1.15rem;">{{ $kelas->nama_kelas }}</h4>
                        <!-- Deskripsi batas maksimal 2 baris agar rapi -->
                        <p class="text-secondary text-sm mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 42px;">
                            {{ $kelas->deskripsi }}
                        </p>
                        
                        @auth
                            @php 
                                $progress = auth()->user()->classProgress($kelas->id);
                                $progressColor = $progress == 100 ? 'bg-gradient-success' : 'bg-gradient-primary';
                            @endphp
                            <div class="class-progress mb-4">
                                <div class="progress-bar mb-2 bg-light border-radius-sm" style="height: 6px;">
                                    <div class="progress-fill {{ $progressColor }} border-radius-sm" style="width: {{ $progress }}%; height: 100%;"></div>
                                </div>
                                <span class="text-xs font-weight-bold {{ $progress == 100 ? 'text-success' : 'text-primary' }}">{{ $progress }}% Target Selesai</span>
                            </div>
                        @endauth
                        
                        <a href="{{ route('kelas.show', $kelas->id) }}" class="btn bg-gradient-primary w-100 font-weight-bold text-white shadow-sm" style="display: block; text-align: center; text-decoration: none;">Cek Informasi Modul</a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Empty state ketika tidak ada hasil --}}
        <div class="filter-empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-search" style="font-size: 2.5rem; color: #d2d6da; margin-bottom: 1rem;"></i>
            <h4 style="color: #344767; margin-bottom: 0.5rem;">Tidak ada kelas ditemukan</h4>
            <p style="color: #67748e; font-size: 0.875rem;">Coba ubah filter atau kata kunci pencarian Anda.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentFilter = 'all';

    function setFilter(btn) {
        // Update active state on buttons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Set current filter
        currentFilter = btn.getAttribute('data-filter');

        // Apply combined filter (category + search)
        filterCards();
    }

    function filterCards() {
        const searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.class-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const category = card.getAttribute('data-category');
            // Penyesuaian Query Selector karena tag judul sekarang adalah h4
            const titleElement = card.querySelector('h4');
            const title = titleElement ? titleElement.textContent.toLowerCase() : '';
            
            const descElement = card.querySelector('.class-info p');
            const description = descElement ? descElement.textContent.toLowerCase() : '';

            const matchesCategory = (currentFilter === 'all' || category === currentFilter);
            const matchesSearch = (searchQuery === '' || title.includes(searchQuery) || description.includes(searchQuery));

            if (matchesCategory && matchesSearch) {
                card.style.display = '';
                card.style.animation = 'fadeInUp 0.4s ease forwards';
                visibleCount++;
            } else {
                card.style.display = 'none';
                card.style.animation = '';
            }
        });

        // Show/hide empty state
        const emptyState = document.getElementById('emptyState');
        emptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
    }
</script>
@endpush
