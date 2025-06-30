@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Katalog
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->title, 30) }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Book Image Section -->
            <div class="col-lg-5">
                <div class="book-detail-image-container">
                    <div class="image-wrapper">
                        <img class="book-detail-image"
                            src="{{ $book->image ? $book->image : asset('images/book-default.png') }}"
                            alt="{{ $book->title }}">
                        <div class="image-shadow"></div>
                    </div>
                </div>
            </div>

            <!-- Book Details Section -->
            <div class="col-lg-7">
                <div class="book-detail-content">
                    <!-- Title -->
                    <div class="book-header mb-4">
                        <h1 class="book-detail-title">{{ $book->title }}</h1>
                    </div>

                    <!-- Book Meta Information -->
                    <div class="book-meta-grid">
                        <div class="meta-card">
                            <div class="meta-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Pengarang</div>
                                <div class="meta-value">{{ $book->author }}</div>
                            </div>
                        </div>

                        <div class="meta-card">
                            <div class="meta-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Kategori</div>
                                <div class="meta-value">{{ $book->category }}</div>
                            </div>
                        </div>

                        <div class="meta-card">
                            <div class="meta-icon">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">ISBN</div>
                                <div class="meta-value">{{ $book->ISBN }}</div>
                            </div>
                        </div>

                        <div class="meta-card">
                            <div class="meta-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Penerbit</div>
                                <div class="meta-value">{{ $book->publisher }}</div>
                            </div>
                        </div>

                        <div class="meta-card">
                            <div class="meta-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Tahun Terbit</div>
                                <div class="meta-value">{{ $book->year_published }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="description-section mt-5">
                        <h3 class="section-title">
                            <i class="fas fa-align-left me-2"></i>Deskripsi Buku
                        </h3>
                        <div class="description-content">
                            <p>{{ $book->description ?: 'Deskripsi belum tersedia untuk buku ini.' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mt-5">
                        <a href="{{ route('index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
