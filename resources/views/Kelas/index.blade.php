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

        {{-- Filter Buttons --}}
        <div class="class-filters" id="categoryFilters">
            <button class="filter-btn active" data-filter="all" onclick="setFilter(this)">
                <i class="fas fa-th-large me-1"></i> Semua
            </button>
            <button class="filter-btn" data-filter="disciple" onclick="setFilter(this)">
                <i class="fas fa-users me-1"></i> Disciple Community
            </button>
            <button class="filter-btn" data-filter="new" onclick="setFilter(this)">
                <i class="fas fa-seedling me-1"></i> Equip - New
            </button>
            <button class="filter-btn" data-filter="plant" onclick="setFilter(this)">
                <i class="fas fa-leaf me-1"></i> Equip - Plant
            </button>
            <button class="filter-btn" data-filter="grow" onclick="setFilter(this)">
                <i class="fas fa-chart-line me-1"></i> Equip - Grow
            </button>
            <button class="filter-btn" data-filter="serve" onclick="setFilter(this)">
                <i class="fas fa-hands-helping me-1"></i> Equip - Serve
            </button>
            <button class="filter-btn" data-filter="lead" onclick="setFilter(this)">
                <i class="fas fa-crown me-1"></i> Equip - Lead
            </button>
        </div>

        <div class="class-grid" id="classGrid">
            <!-- 1. CTT -->
            <div class="class-card" data-category="disciple">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved0.jpg') }}" alt="CTT">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-disciple">Disciple Community</span>
                    <h3>CTT (Core Team Training)</h3>
                    <p>Membangun tim inti yang kuat dan berdedikasi.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 2. DMT -->
            <div class="class-card" data-category="disciple">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved1.jpg') }}" alt="DMT">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-disciple">Disciple Community</span>
                    <h3>DMT (Disciple Maker Training)</h3>
                    <p>Pelatihan untuk menjadi pembuat murid yang efektif.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 3. Foundation Class 1 -->
            <div class="class-card" data-category="new">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved6.jpg') }}" alt="Foundation 1">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-new">Equip - New</span>
                    <h3>Foundation Class 1</h3>
                    <p>Dasar Keselamatan dan Baptisan (Salvation & Baptism).</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 4. Membership Class -->
            <div class="class-card" data-category="new">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved8.jpg') }}" alt="Membership">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-new">Equip - New</span>
                    <h3>Membership Class</h3>
                    <p>Memahami visi, misi, dan komitmen sebagai anggota.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 5. Foundation Class 2 -->
            <div class="class-card" data-category="plant">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved14.jpg') }}" alt="Foundation 2">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-plant">Equip - Plant</span>
                    <h3>Foundation Class 2</h3>
                    <p>Membangun kebiasaan Doa, Alkitab, dan Komunitas.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 6. Foundation Class 3 -->
            <div class="class-card" data-category="plant">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/white-curved.jpeg') }}" alt="Foundation 3">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-plant">Equip - Plant</span>
                    <h3>Foundation Class 3</h3>
                    <p>Renewal Life: Pemulihan dan pembaharuan hidup.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 7. Grade 1 -->
            <div class="class-card" data-category="grow">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved0.jpg') }}" alt="Grade 1">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-grow">Equip - Grow</span>
                    <h3>Grade 1 (The Cross)</h3>
                    <p>Mendalami makna dan kuasa Salib Kristus.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 8. Grade 2 -->
            <div class="class-card" data-category="grow">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved1.jpg') }}" alt="Grade 2">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-grow">Equip - Grow</span>
                    <h3>Grade 2 (The Power)</h3>
                    <p>Mengalami kuasa Roh Kudus dalam kehidupan sehari-hari.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 9. Grade 3 -->
            <div class="class-card" data-category="grow">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved6.jpg') }}" alt="Grade 3">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-grow">Equip - Grow</span>
                    <h3>Grade 3 (The Eternity)</h3>
                    <p>Hidup dengan perspektif kekekalan.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 10. Volunteer Class -->
            <div class="class-card" data-category="serve">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved8.jpg') }}" alt="Volunteer">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-serve">Equip - Serve</span>
                    <h3>Volunteer Class</h3>
                    <p>Persiapan untuk melayani di berbagai departemen.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

            <!-- 11. Leadership Class -->
            <div class="class-card" data-category="lead">
                <div class="class-image">
                    <img src="{{ asset('img/curved-images/curved14.jpg') }}" alt="Leadership">
                </div>
                <div class="class-info">
                    <span class="class-category bg-category-lead">Equip - Lead</span>
                    <h3>Leadership Class</h3>
                    <p>Membangun jiwa kepemimpinan yang berintegritas.</p>
                    <div class="class-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span>0% Selesai</span>
                    </div>
                    <button class="btn-enter-class">Masuk Kelas</button>
                </div>
            </div>

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
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('.class-info p').textContent.toLowerCase();

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
