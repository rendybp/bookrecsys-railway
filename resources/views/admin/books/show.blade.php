@extends('admin.layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-book"></i> Detail Buku</h2>
            <div>
                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                @if($book->image)
                <img src="{{ $book->image }}"
                     alt="{{ $book->title }}"
                     class="img-fluid rounded shadow-sm mb-3"
                     style="max-height: 400px; object-fit: cover;">
                @else
                <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3"
                     style="height: 300px;">
                    <div class="text-center">
                        <i class="fas fa-book fa-4x text-muted mb-2"></i>
                        <p class="text-muted">Tidak ada gambar</p>
                    </div>
                </div>
                @endif

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Buku
                    </a>
                    <button type="button" class="btn btn-danger"
                            onclick="deleteBook({{ $book->id }}, '{{ $book->title }}')">
                        <i class="fas fa-trash"></i> Hapus Buku
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Buku</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Judul:</label>
                        <h4 class="mb-0">{{ $book->title }}</h4>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Kategori:</label>
                        <div>
                            <span class="badge bg-info fs-6">{{ $book->category }}</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Penulis:</label>
                        <p class="mb-0 fs-5">{{ $book->author }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Penerbit:</label>
                        <p class="mb-0 fs-5">{{ $book->publisher }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Tahun Terbit:</label>
                        <p class="mb-0 fs-5">{{ $book->year_published }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">ISBN:</label>
                        <p class="mb-0 fs-5">{{ $book->ISBN }}</p>
                    </div>

                    @if($book->description)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold text-muted">Deskripsi:</label>
                        <div class="border rounded p-3 bg-light">
                            <p class="mb-0">{{ $book->description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="col-12">
                        <hr>
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-calendar-plus"></i>
                                <strong>Ditambahkan:</strong> {{ $book->created_at->format('d F Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-calendar-edit"></i>
                                <strong>Terakhir diupdate:</strong> {{ $book->updated_at->format('d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Card -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Aksi Lainnya</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Tambah Buku Baru
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-list"></i> Semua Buku
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('book.show', $book) }}" target="_blank" class="btn btn-outline-primary w-100">
                            <i class="fas fa-external-link-alt"></i> Lihat di Katalog
                        </a>
                    </div>
                </div>
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

<script>
function deleteBook(id, title) {
    document.getElementById('bookTitle').textContent = title;
    document.getElementById('deleteForm').action = '/admin/books/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
