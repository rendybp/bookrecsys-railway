<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Book Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #34495e;
            color: #3498db;
        }
        .profile-section {
            background: #34495e;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .profile-icon {
            width: 80px;
            height: 80px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 30px;
            color: white;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="text-center text-white mb-4">
                        <i class="fas fa-book"></i> Admin Panel
                    </h4>

                    <!-- Profile Section -->
                    <div class="profile-section">
                        <div class="profile-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h6 class="text-white mb-1">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                        <div class="mt-2">
                            <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>

                        <a class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
                           href="{{ route('admin.books.index') }}">
                            <i class="fas fa-book"></i> Manajemen Buku
                        </a>

                        @if(Auth::user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Manajemen User
                        </a>
                        @endif

                        <hr class="my-3" style="border-color: #34495e;">

                        <a class="nav-link" href="{{ route('index') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Lihat Katalog
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logout-form">
                            @csrf
                            <button type="button" class="nav-link btn btn-link text-start w-100 p-0"
                                    style="color: #ecf0f1 !important; text-decoration: none;"
                                    data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                            @yield('title', 'Dashboard')
                        </a>

                        <div class="navbar-nav ms-auto">
                            <span class="navbar-text">
                                Selamat datang, <strong>{{ Auth::user()->name }}</strong>
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="container-fluid py-4">
                    <!-- Alert Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-sign-out-alt text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="mb-3">Apakah Anda yakin ingin keluar?</h6>
                    <p class="text-muted mb-0">
                        Anda akan diwajibkan untuk login kembali untuk mengakses halaman ini.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt me-2"></i>Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmLogout() {
            // Hide the modal first
            const modal = bootstrap.Modal.getInstance(document.getElementById('logoutModal'));
            modal.hide();

            // Submit the logout form
            document.getElementById('logout-form').submit();
        }
    </script>
</body>
</html>
