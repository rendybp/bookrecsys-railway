@extends('admin.layouts.app')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-plus"></i> Tambah Buku Baru</h2>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Buku
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-book"></i> Form Tambah Buku</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.books.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required
                                       placeholder="Masukkan judul buku">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror"
                                       id="author" name="author" value="{{ old('author') }}" required
                                       placeholder="Nama penulis">
                                @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="publisher" class="form-label">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                       id="publisher" name="publisher" value="{{ old('publisher') }}" required
                                       placeholder="Nama penerbit">
                                @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year_published" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('year_published') is-invalid @enderror"
                                       id="year_published" name="year_published" value="{{ old('year_published') }}"
                                       min="1000" max="{{ date('Y') }}" required
                                       placeholder="Contoh: {{ date('Y') }}">
                                @error('year_published')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ISBN" class="form-label">ISBN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ISBN') is-invalid @enderror"
                                       id="ISBN" name="ISBN" value="{{ old('ISBN') }}" required
                                       placeholder="Contoh: 978-3-16-148410-0">
                                @error('ISBN')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror"
                                       id="category" name="category" value="{{ old('category') }}" required
                                       placeholder="Contoh: Fiksi, Non-fiksi, Sejarah, dll."
                                       list="categoryList">
                                <datalist id="categoryList">
                                    <option value="Fiksi">
                                    <option value="Non-fiksi">
                                    <option value="Sejarah">
                                    <option value="Sains">
                                    <option value="Teknologi">
                                    <option value="Biografi">
                                    <option value="Pendidikan">
                                    <option value="Kesehatan">
                                    <option value="Ekonomi">
                                    <option value="Politik">
                                </datalist>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">URL Gambar Cover</label>
                                <input type="url" class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" value="{{ old('image') }}"
                                       placeholder="https://example.com/cover-image.jpg">
                                <small class="text-muted">Masukkan URL gambar cover buku (opsional)</small>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="Masukkan deskripsi atau sinopsis buku (opsional)">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Preview image if URL is provided
document.getElementById('image').addEventListener('input', function() {
    const url = this.value;
    const existingPreview = document.getElementById('imagePreview');

    if (existingPreview) {
        existingPreview.remove();
    }

    if (url) {
        const preview = document.createElement('div');
        preview.id = 'imagePreview';
        preview.className = 'mt-2';
        preview.innerHTML = `
            <small class="text-muted">Preview:</small><br>
            <img src="${url}" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 200px;"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <div class="text-danger small" style="display: none;">Gagal memuat gambar. Periksa URL.</div>
        `;
        this.parentNode.appendChild(preview);
    }
});
</script>
@endsection
