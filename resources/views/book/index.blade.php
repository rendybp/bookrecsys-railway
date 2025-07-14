@extends('layouts.main')

@section('content')
    <!-- Hero Section with Gradient Background -->
    <div class="hero-section mb-5">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="hero-title mb-4">Temukan Buku Favorit Anda</h1>
                    <p class="hero-subtitle mb-4">Jelajahi koleksi ribuan buku dengan sistem rekomendasi AI yang canggih</p>

                    <!-- AI Recommendation Search - Featured -->
                    <form method="GET" action="{{ route('index') }}" class="ai-search-form">
                        <div class="search-container">
                            <div class="search-input-wrapper">
                                <i class="fas fa-magic search-icon"></i>
                                <input type="text" name="search_rekom" id="search_rekom"
                                    class="ai-search-input"
                                    placeholder="Cari rekomendasi dengan AI... (contoh: 'petualangan fantasi')"
                                    value="{{ request('search_rekom') }}">

                                @if (request('search_rekom'))
                                    <button type="button" class="clear-btn" onclick="clearSearchRekom()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                            <button type="submit" class="ai-search-btn">
                                <i class="fas fa-sparkles me-2"></i>
                                Rekomendasi AI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row">
            <!-- Enhanced Sidebar Filter -->
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <h5><i class="fas fa-filter me-2"></i>Filter Pencarian</h5>
                    </div>

                    <div class="filter-body">
                        <form method="GET" action="{{ route('index') }}" class="filter-form">
                            <!-- Manual Search -->
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-search me-2"></i>Pencarian Manual
                                </label>
                                <div class="search-input-group">
                                    <input type="text" id="search" name="search"
                                        class="filter-input"
                                        placeholder="Judul, Pengarang, Penerbit..."
                                        value="{{ request('search') }}">

                                    @if (request('search'))
                                        <button type="button" class="input-clear-btn" onclick="clearSearch()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-tags me-2"></i>Kategori
                                </label>
                                <select id="category" name="category" class="filter-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year Filter -->
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="fas fa-calendar me-2"></i>Tahun Terbit
                                </label>
                                <select id="year" name="year" class="filter-select">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="filter-apply-btn">
                                <i class="fas fa-search me-2"></i>Terapkan Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Books Grid -->
            <div class="col-lg-8 col-xl-9">
                <!-- Active Filters Display -->
                @if(request('search') || request('category') || request('year') || request('search_rekom'))
                <div class="active-filters mb-4">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="filter-label-text">Filter Aktif:</span>

                        @if(request('search'))
                            <span class="filter-badge">
                                <i class="fas fa-search me-1"></i>
                                Pencarian: "{{ request('search') }}"
                                <a href="{{ route('index', request()->except('search')) }}" class="filter-remove">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(request('search_rekom'))
                            <span class="filter-badge ai-badge">
                                <i class="fas fa-magic me-1"></i>
                                AI: "{{ request('search_rekom') }}"
                                <a href="{{ route('index', request()->except('search_rekom')) }}" class="filter-remove">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(request('category'))
                            <span class="filter-badge">
                                <i class="fas fa-tag me-1"></i>
                                {{ request('category') }}
                                <a href="{{ route('index', request()->except('category')) }}" class="filter-remove">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(request('year'))
                            <span class="filter-badge">
                                <i class="fas fa-calendar me-1"></i>
                                {{ request('year') }}
                                <a href="{{ route('index', request()->except('year')) }}" class="filter-remove">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        <a href="{{ route('index') }}" class="clear-all-filters">
                            <i class="fas fa-times-circle me-1"></i>Hapus Semua
                        </a>
                    </div>
                </div>
                @endif

                <!-- Books Grid -->
                <div class="books-grid">
                    @forelse ($books as $book)
                        <div class="book-card-wrapper">
                            <div class="book-card">
                                @if (isset($similarityMap) && isset($similarityMap[$book->id]))
                                    <div class="ai-score-badge" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Skor Rekomendasi AI: {{ number_format($similarityMap[$book->id], 3) }}. Semakin tinggi skor, semakin relevan dengan pencarian Anda.">
                                        <i class="fas fa-robot me-1"></i>
                                        {{ number_format($similarityMap[$book->id], 3) }}
                                    </div>
                                @endif

                                <div class="book-image-container">
                                    <img src="{{ $book->image ? $book->image : asset('images/book-default.png') }}"
                                        class="book-image" alt="{{ $book->title }}">
                                    <div class="book-overlay">
                                        <a href="{{ route('book.show', $book->id) }}" class="quick-view-btn">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>

                                <div class="book-content">
                                    <h5 class="book-title">{{ $book->title }}</h5>

                                    <div class="book-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <span>{{ $book->author }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-tag text-success me-2"></i>
                                            <span>{{ $book->category }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-calendar text-info me-2"></i>
                                            <span>{{ $book->year_published }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('book.show', $book->id) }}" class="detail-btn">
                                        <i class="fas fa-book-open me-2"></i>Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Tidak Ada Buku Ditemukan</h3>
                            <p>Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
                            <a href="{{ route('index') }}" class="btn-reset">
                                <i class="fas fa-refresh me-2"></i>Reset Pencarian
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Enhanced Pagination -->
                @if($books->hasPages())
                <div class="pagination-wrapper">
                    {{ $books->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
