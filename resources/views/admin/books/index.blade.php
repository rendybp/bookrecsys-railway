@extends('admin.layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<style>
/* Mobile Responsive Pagination */
.pagination-wrapper .pagination {
    flex-wrap: wrap;
    justify-content: center;
}

@media (max-width: 576px) {
    .pagination-wrapper .pagination {
        font-size: 0.8rem;
    }

    .pagination-wrapper .page-link {
        padding: 0.25rem 0.5rem;
        margin: 0 1px;
        min-width: 32px;
        text-align: center;
    }

    /* Hide some pagination numbers on very small screens */
    .pagination-wrapper .pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
        display: none;
    }

    /* Show ellipsis instead */
    .pagination-wrapper .pagination .page-item:nth-child(3)::after {
        content: "...";
        position: absolute;
        right: -15px;
        color: #6c757d;
    }
}

@media (max-width: 480px) {
    .pagination-wrapper .pagination {
        font-size: 0.75rem;
    }

    .pagination-wrapper .page-link {
        padding: 0.2rem 0.4rem;
        min-width: 28px;
    }
}
</style>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-book"></i> Manajemen Buku</h2>
            <div>
                <div class="btn-group-vertical btn-group-sm d-md-none" role="group">
                    <a href="{{ route('admin.books.export.csv') }}" class="btn btn-success mb-1">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                    <a href="{{ route('admin.books.test.fastapi') }}" class="btn btn-info mb-1">
                        <i class="fas fa-wifi"></i> Test Connection
                    </a>
                    <button type="button" class="btn btn-warning mb-1" onclick="trainRecommendationSystem()">
                        <i class="fas fa-robot"></i> Train AI Model
                    </button>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </a>
                </div>
                <div class="btn-group d-none d-md-flex" role="group">
                    <a href="{{ route('admin.books.export.csv') }}" class="btn btn-success me-2">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                    <a href="{{ route('admin.books.test.fastapi') }}" class="btn btn-info me-2">
                        <i class="fas fa-wifi"></i> Test Connection
                    </a>
                    <button type="button" class="btn btn-warning me-2" onclick="trainRecommendationSystem()">
                        <i class="fas fa-robot"></i> Train AI Model
                    </button>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-2 mb-lg-0">
                                <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Buku</h5>
                            </div>
                            <div class="col-lg-6">
                                <!-- Mobile Form -->
                                <form method="GET" action="{{ route('admin.books.index') }}" class="d-lg-none" id="mobileFilterForm">
                                    <div class="mb-2">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               name="search"
                                               value="{{ request('search') }}"
                                               placeholder="Cari buku...">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="category" class="form-select form-select-sm">
                                                <option value="">Semua Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select name="year_published" class="form-select form-select-sm">
                                                <option value="">Semua Tahun</option>
                                                @foreach($years as $year)
                                                    <option value="{{ $year }}" {{ request('year_published') == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-outline-primary btn-sm me-2">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        @if(request('search') || request('category') || request('year_published'))
                                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                        @endif
                                    </div>
                                </form>

                                <!-- Desktop Form -->
                                <form method="GET" action="{{ route('admin.books.index') }}" class="d-none d-lg-flex align-items-end" style="gap: 8px;" id="desktopFilterForm">
                                    <!-- Search Input -->
                                    <div class="flex-grow-1">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               name="search"
                                               value="{{ request('search') }}"
                                               placeholder="Cari buku">
                                    </div>

                                    <!-- Category Filter -->
                                    <div style="min-width: 160px;">
                                        <select name="category" class="form-select form-select-sm">
                                            <option value="">Semua Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Year Filter -->
                                    <div style="min-width: 140px;">
                                        <select name="year_published" class="form-select form-select-sm">
                                            <option value="">Semua Tahun</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ request('year_published') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Button -->
                                    <button type="submit" class="btn btn-outline-primary btn-sm" style="min-width: 40px;">
                                        <i class="fas fa-search"></i>
                                    </button>

                                    <!-- Clear Filter Button -->
                                    @if(request('search') || request('category') || request('year_published'))
                                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-sm" style="min-width: 40px;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($books->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th width="80">Gambar</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th width="80">Tahun</th>
                                <th>Kategori</th>
                                <th width="140">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{ $books->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($book->image)
                                    <img src="{{ $book->image }}"
                                         alt="{{ $book->title }}"
                                         class="img-thumbnail"
                                         style="width: 50px; height: 70px; object-fit: cover;">
                                    @else
                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 70px;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $book->title }}</strong>
                                    <br><small class="text-muted">ISBN: {{ $book->ISBN }}</small>
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->year_published }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $book->category }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.books.show', $book) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.books.edit', $book) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus"
                                                onclick="deleteBook({{ $book->id }}, '{{ $book->title }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $books->firstItem() }} sampai {{ $books->lastItem() }}
                            dari {{ $books->total() }} buku
                            @if(request('search') || request('category') || request('year_published'))
                                <span class="text-info">(dengan filter)</span>
                            @endif
                        </small>

                        @if(request('search') || request('category') || request('year_published'))
                            <div class="mt-1">
                                @if(request('search'))
                                    <span class="badge bg-info me-1">Pencarian: "{{ request('search') }}"</span>
                                @endif
                                @if(request('category'))
                                    <span class="badge bg-success me-1">Kategori: {{ request('category') }}</span>
                                @endif
                                @if(request('year_published'))
                                    <span class="badge bg-warning me-1">Tahun: {{ request('year_published') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="pagination-wrapper">
                            {{ $books->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        @if(request('search') || request('category') || request('year_published'))
                            Tidak ada buku yang ditemukan dengan filter yang dipilih
                        @else
                            Belum ada buku yang tersedia
                        @endif
                    </h5>

                    @if(request('search') || request('category') || request('year_published'))
                        <div class="mb-3">
                            @if(request('search'))
                                <span class="badge bg-info me-1">Pencarian: "{{ request('search') }}"</span>
                            @endif
                            @if(request('category'))
                                <span class="badge bg-success me-1">Kategori: {{ request('category') }}</span>
                            @endif
                            @if(request('year_published'))
                                <span class="badge bg-warning me-1">Tahun: {{ request('year_published') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Hapus Semua Filter
                        </a>
                    @else
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Buku Pertama
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-trash"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku <strong id="bookTitle"></strong>?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Train Recommendation System Modal -->
<div class="modal fade" id="trainModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-robot"></i> Train AI Recommendation System</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Proses Training AI</strong>
                    <p class="mb-0 mt-2">Sistem akan:</p>
                    <ul class="mb-0">
                        <li>Mengeksport semua data buku ({{ \App\Models\Book::count() }} buku)</li>
                        <li>Mengirim data ke sistem AI untuk melatih model rekomendasi</li>
                        <li>Memperbarui algoritma rekomendasi dengan data terbaru</li>
                        <li>Proses akan memakan waktu beberapa beberapa menit</li>
                    </ul>
                </div>
                <p><strong>Apakah Anda yakin ingin memulai proses training?</strong></p>
                <p class="text-muted">Pastikan Anda memiliki koneksi internet yang stabil.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.books.train.recommendation') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning" id="trainButton">
                        <i class="fas fa-robot"></i> Mulai Training
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteBook(id, title) {
    document.getElementById('bookTitle').textContent = title;
    document.getElementById('deleteForm').action = '/admin/books/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function trainRecommendationSystem() {
    const modal = new bootstrap.Modal(document.getElementById('trainModal'));
    modal.show();

    // Add loading state when form is submitted
    document.querySelector('#trainModal form').addEventListener('submit', function() {
        const button = document.getElementById('trainButton');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Training AI Model...';
        button.disabled = true;

        // Show training progress
        const modalBody = document.querySelector('#trainModal .modal-body');
        modalBody.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                <strong>AI Training Sedang Berlangsung...</strong>
                <p class="mb-0 mt-2">Proses sedang berlangsung, mohon tunggu...</p>
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
            <div class="text-center">
                <i class="fas fa-robot fa-3x text-warning mb-3"></i>
                <h5>Sedang Melatih Model AI...</h5>
                <p class="text-muted">Sistem sedang memproses ${document.querySelector('.alert-info ul li:first-child').textContent.match(/\\d+/)[0]} buku untuk meningkatkan akurasi rekomendasi.</p>
            </div>
        `;
    });
}

// Auto-submit form when filter dropdowns change (both mobile and desktop)
document.addEventListener('DOMContentLoaded', function() {

    // Get forms
    const mobileForm = document.getElementById('mobileFilterForm');
    const desktopForm = document.getElementById('desktopFilterForm');

    // Function to add auto-submit to select elements
    function addAutoSubmit() {
        // Mobile selects
        if (mobileForm) {
            const mobileCategorySelect = mobileForm.querySelector('select[name="category"]');
            const mobileYearSelect = mobileForm.querySelector('select[name="year_published"]');

            if (mobileCategorySelect) {
                mobileCategorySelect.addEventListener('change', function() {
                    console.log('Mobile category changed:', this.value);
                    mobileForm.submit();
                });
            }
            if (mobileYearSelect) {
                mobileYearSelect.addEventListener('change', function() {
                    console.log('Mobile year changed:', this.value);
                    mobileForm.submit();
                });
            }
        }

        // Desktop selects
        if (desktopForm) {
            const desktopCategorySelect = desktopForm.querySelector('select[name="category"]');
            const desktopYearSelect = desktopForm.querySelector('select[name="year_published"]');

            if (desktopCategorySelect) {
                desktopCategorySelect.addEventListener('change', function() {
                    console.log('Desktop category changed:', this.value);
                    desktopForm.submit();
                });
            }
            if (desktopYearSelect) {
                desktopYearSelect.addEventListener('change', function() {
                    console.log('Desktop year changed:', this.value);
                    desktopForm.submit();
                });
            }
        }
    }

    // Function to remove auto-submit from all select elements
    function removeAutoSubmit() {
        const allSelects = document.querySelectorAll('#mobileFilterForm select, #desktopFilterForm select');
        allSelects.forEach(select => {
            select.removeEventListener('change', autoSubmit);
        });
    }

    // Auto-submit function (fallback)
    function autoSubmit() {
        const form = this.closest('form');
        if (form) {
            form.submit();
        }
    }

    // Initial setup
    addAutoSubmit();

    // Handle window resize to re-apply auto-submit logic
    window.addEventListener('resize', function() {
        setTimeout(function() {
            removeAutoSubmit();
            addAutoSubmit();
        }, 100);
    });

    // Debug: Log when forms are found
    console.log('Mobile form found:', !!mobileForm);
    console.log('Desktop form found:', !!desktopForm);
});
</script>
@endsection
