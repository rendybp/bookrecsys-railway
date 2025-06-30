@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            <small class="text-muted">{{ date('l, d F Y') }}</small>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white p-3 rounded">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="mb-0">{{ $totalBooks }}</h3>
                        <p class="text-muted mb-0">Total Buku</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->isAdmin())
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white p-3 rounded">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="mb-0">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i><br>
                            Tambah Buku Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-list"></i><br>
                            Daftar Buku
                        </a>
                    </div>
                    @if(Auth::user()->isAdmin())
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i><br>
                            Tambah User Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-users-cog"></i><br>
                            Kelola User
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Welcome Section -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5><i class="fas fa-info-circle"></i> Selamat Datang di Admin Panel</h5>
                <p class="text-muted mb-3">
                    Sistem manajemen buku perpustakaan. Gunakan menu navigasi di sebelah kiri untuk mengelola buku-buku
                    @if(Auth::user()->isAdmin())
                    dan pengguna sistem
                    @endif
                    .
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user-check"></i> Hak Akses Anda:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Manajemen Buku</li>
                            @if(Auth::user()->isAdmin())
                            <li><i class="fas fa-check text-success"></i> Manajemen User</li>
                            @endif
                            <li><i class="fas fa-check text-success"></i> Update Profile</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-external-link-alt"></i> Tautan Berguna:</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('index') }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-book-open"></i> Lihat Katalog Buku
                            </a></li>
                            <li><a href="{{ route('admin.profile') }}" class="text-decoration-none">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
