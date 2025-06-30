<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --white: #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== GLOBAL STYLES ===== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .container-fluid {
            background: transparent;
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 0 0 2rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>') repeat;
            opacity: 0.3;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            font-weight: 400;
        }

        /* ===== AI SEARCH FORM ===== */
        .ai-search-form {
            position: relative;
            z-index: 10;
        }

        .search-container {
            display: flex;
            gap: 1rem;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            z-index: 5;
        }

        .ai-search-input {
            width: 100%;
            padding: 1rem 3rem 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .ai-search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3), var(--shadow-xl);
            transform: translateY(-2px);
        }

        .clear-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--gray-400);
            cursor: pointer;
            transition: var(--transition);
        }

        .clear-btn:hover {
            color: var(--danger-color);
        }

        .ai-search-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            background: linear-gradient(45deg, var(--warning-color), #fb923c);
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            white-space: nowrap;
        }

        .ai-search-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        /* ===== FILTER SIDEBAR ===== */
        .filter-sidebar {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            position: sticky;
            top: 2rem;
        }

        .filter-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 1.5rem;
        }

        .filter-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .filter-body {
            padding: 1.5rem;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .search-input-group {
            position: relative;
        }

        .filter-input, .filter-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            transition: var(--transition);
            background: white;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .input-clear-btn {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.25rem;
        }

        .filter-apply-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: var(--border-radius);
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            font-weight: 600;
            transition: var(--transition);
        }

        .filter-apply-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ===== ACTIVE FILTERS ===== */
        .active-filters {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .filter-label-text {
            font-weight: 600;
            color: var(--gray-600);
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .filter-badge.ai-badge {
            background: linear-gradient(45deg, var(--warning-color), #fb923c);
        }

        .filter-remove {
            margin-left: 0.5rem;
            color: white;
            text-decoration: none;
            opacity: 0.8;
        }

        .filter-remove:hover {
            opacity: 1;
        }

        .clear-all-filters {
            color: var(--danger-color);
            text-decoration: none;
            font-weight: 500;
        }

        /* ===== BOOKS GRID ===== */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .book-card-wrapper {
            transition: var(--transition);
        }

        .book-card {
            background: white;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .ai-score-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: linear-gradient(45deg, var(--warning-color), #fb923c);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: var(--shadow-md);
            z-index: 10;
            cursor: help;
        }

        .book-image-container {
            position: relative;
            height: auto;
            min-height: 300px;
            overflow: hidden;
        }

        .book-image {
            width: 100%;
            height: auto;
            min-height: 300px;
            object-fit: cover;
            object-position: top center;
            transition: var(--transition);
        }

        .book-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            display: flex;
            align-items: end;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            transition: var(--transition);
        }

        .book-card:hover .book-overlay {
            opacity: 1;
        }

        .quick-view-btn {
            background: white;
            color: var(--primary-color);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .book-card:hover .quick-view-btn {
            transform: translateY(0);
        }

        .book-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-meta {
            flex: 1;
            margin-bottom: 0.75rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.4rem;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .detail-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 0.6rem 0.8rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            margin-top: auto;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-reset:hover {
            background: var(--primary-dark);
            color: white;
        }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Mobile Responsive Pagination */
        @media (max-width: 576px) {
            .pagination-wrapper {
                margin-top: 2rem;
            }
            
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

        /* ===== BOOK DETAIL STYLES ===== */
        .breadcrumb {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .book-detail-image-container {
            position: sticky;
            top: 2rem;
        }

        .image-wrapper {
            position: relative;
            text-align: center;
        }

        .book-detail-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
        }

        .image-shadow {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            height: 90%;
            background: var(--primary-color);
            border-radius: var(--border-radius-lg);
            opacity: 0.1;
            z-index: -1;
        }

        .quick-actions {
            margin-top: 2rem;
        }

        .action-btn {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            background: white;
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
            text-align: center;
        }

        .action-btn:hover, .action-btn.active {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
        }

        .book-detail-content {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .book-detail-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stars {
            color: var(--warning-color);
        }

        .rating-text {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .book-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .meta-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .meta-card:hover {
            background: var(--primary-color);
            color: white;
        }

        .meta-card:hover .meta-icon {
            color: white;
        }

        .meta-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .meta-label {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .meta-value {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .availability-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .availability-badge.available {
            background: var(--success-color);
            color: white;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .description-content {
            color: var(--gray-600);
            line-height: 1.6;
            font-size: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-back {
            padding: 1rem 2rem;
            border: 2px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-back:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-primary-action {
            padding: 1rem 2rem;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .related-books-section {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .related-book-card {
            background: var(--gray-50);
            border-radius: var(--border-radius);
            padding: 1rem;
            text-align: center;
            transition: var(--transition);
        }

        .related-book-card:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-4px);
        }

        .related-book-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .search-container {
                flex-direction: column;
            }

            .book-detail-title {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }

            .book-image-container {
                min-height: 280px;
            }

            .book-image {
                min-height: 280px;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 1rem;
            }

            .book-meta-grid {
                grid-template-columns: 1fr;
            }

            .book-image-container {
                min-height: 250px;
            }

            .book-image {
                min-height: 250px;
            }
        }

        @media (max-width: 576px) {
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 0.75rem;
            }

            .book-image-container {
                min-height: 220px;
            }

            .book-image {
                min-height: 220px;
            }

            .book-content {
                padding: 0.75rem;
            }
        }

        /* ===== LEGACY COMPATIBILITY ===== */
        .hover-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .hover-shadow:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
        }

        .card-title {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .card-text {
            min-height: 5em;
        }

        .select2-container--default .select2-selection--single {
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            height: 45px;
            padding: 6px 12px;
            font-size: 14px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 31px;
            color: var(--gray-700);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
            right: 10px;
        }

        button[onclick="clearSearch()"], button[onclick="clearSearchRekom()"] {
            border: none;
            background: transparent;
            font-size: 1.25rem;
            line-height: 1;
            color: var(--gray-400);
            transition: var(--transition);
        }

        button[onclick="clearSearch()"]:hover, button[onclick="clearSearchRekom()"]:hover {
            color: var(--danger-color);
        }

        .badge-similarity {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: var(--shadow-md);
            cursor: help;
            transition: var(--transition);
            z-index: 10;
        }

        .badge-similarity:hover {
            box-shadow: var(--shadow-lg);
            transform: scale(1.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-light:hover {
            background-color: var(--gray-200);
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-primary sticky-top" data-bs-theme="dark">
        <div class="container-fluid px-3 py-1 d-flex justify-content-between">

            <!-- Brand -->
            <a class="navbar-brand mb-0 h1 text-white" href="/">Perpustakaan</a>

            <!-- Navbar toggler for main menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links and items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Katalog</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                            </a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item">
                        @if (Auth::check())
                            <span class="navbar-text text-white me-3">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : 'info' }} ms-1">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100 p-0"
                                    style="color: #ecf0f1 !important; text-decoration: none;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="/login" class="text-white text-decoration-none">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row w-100 h-100 my-3 mx-2 pe-3">
            @yield('content')
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#category').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                width: '100%'
            });

            $('#year').select2({
                placeholder: "Pilih Tahun Terbit",
                allowClear: true,
                width: '100%'
            });

            // Auto-submit form saat filter berubah
            $('#category, #year').on('change', function() {
                $(this).closest('form').submit();
            });
        });
    </script>

    <script>
        function clearSearch() {
            const input = document.getElementById('search');
            input.value = '';
            input.form.submit();
        }
    </script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
    </script>

    <script>
        function clearSearchRekom() {
            const input = document.getElementById('search_rekom');
            input.value = '';
            input.form.submit();
        }
    </script>




    @yield('script-js')

</body>

</html>
