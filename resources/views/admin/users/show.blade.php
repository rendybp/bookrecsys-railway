@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-user"></i> Detail User</h2>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle"></i> Informasi User</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Icon Display -->
                    <div class="col-md-12 text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="width: 100px; height: 100px; font-size: 40px;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <h4 class="mt-3">{{ $user->name }}</h4>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-6">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <!-- User Details -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Nama Lengkap:</label>
                        <p class="mb-0 fs-5">{{ $user->name }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Username:</label>
                        <p class="mb-0 fs-5">{{ $user->username }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Email:</label>
                        <p class="mb-0 fs-5">{{ $user->email }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">ID Anggota:</label>
                        <p class="mb-0 fs-5">{{ $user->member_id ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">No. HP:</label>
                        <p class="mb-0 fs-5">{{ $user->no_hp ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted">Role:</label>
                        <div>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-6">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr>
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-calendar-plus"></i>
                                <strong>Terdaftar:</strong> {{ $user->created_at->format('d F Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-calendar-edit"></i>
                                <strong>Terakhir diupdate:</strong> {{ $user->updated_at->format('d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Card -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Aksi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning w-100">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i> Tambah User Baru
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        @if($user->id !== Auth::id())
                        <button type="button" class="btn btn-danger w-100"
                                onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                            <i class="fas fa-trash"></i> Hapus User
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-lock"></i> Tidak dapat dihapus
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Information -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-shield-alt"></i> Hak Akses</h6>
            </div>
            <div class="card-body">
                @if($user->role === 'admin')
                <div class="alert alert-info mb-0">
                    <h6><i class="fas fa-crown"></i> Administrator</h6>
                    <ul class="mb-0">
                        <li>Mengelola semua buku (Create, Read, Update, Delete)</li>
                        <li>Mengelola semua user (Create, Read, Update, Delete)</li>
                        <li>Update data profile</li>
                        <li>Akses penuh ke semua fitur sistem</li>
                    </ul>
                </div>
                @else
                <div class="alert alert-primary mb-0">
                    <h6><i class="fas fa-user"></i> User (Pustakawan Biasa)</h6>
                    <ul class="mb-0">
                        <li>Mengelola semua buku (Create, Read, Update, Delete)</li>
                        <li>Update data profile</li>
                        <li>Tidak dapat mengelola user lain</li>
                    </ul>
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
                <p>Apakah Anda yakin ingin menghapus user <strong id="userName"></strong>?</p>
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
function deleteUser(id, name) {
    document.getElementById('userName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/users/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
