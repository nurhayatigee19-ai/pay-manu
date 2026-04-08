<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pembayaran Siswa')</title>

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS bawaan template -->
    @include('includes.style')

    {{-- ===============================
        🔥 GLOBAL DESIGN SYSTEM
    =============================== --}}
    <style>
    /* ===============================
       BUTTON TAMBAH (GLOBAL)
    =============================== */
    .btn-add {
        background: #198754;
        color: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-add:hover {
        background: #157347;
        color: #fff;
        transform: translateY(-1px);
    }

    /* ===============================
       BUTTON ICON (AKSI)
    =============================== */
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .btn-edit { background: #0d6efd; color: #fff; }
    .btn-delete { background: #dc3545; color: #fff; }
    .btn-reset { background: #ffc107; color: #000; }

    .btn-icon:hover {
        opacity: 0.9;
    }

    /* ===============================
       TABLE
    =============================== */
    .table-theme thead th {
        background-color: #198754 !important;
        color: #ffffff !important;
        text-align: center;
    }

    /* ===============================
       CARD
    =============================== */
    .card {
        border-radius: 12px;
    }

    /* ===============================
       HEADER FLEX (JUDUL + TOMBOL)
    =============================== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    </style>

    {{-- STYLE TAMBAHAN PER HALAMAN --}}
    @stack('styles')
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('Template/assets/compiled/svg/logo.svg') }}" alt="Logo">
                            </a>
                        </div>

                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark">
                                <label class="form-check-label"></label>
                            </div>
                        </div>

                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>

                    </div>
                </div>

                @include('includes.sidebar')
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-content">
                @yield('content')
            </div>

            @include('includes.footer')
        </div>
    </div>

    <!-- JS -->
    @include('includes.script')

    {{-- SCRIPT TAMBAHAN PER HALAMAN --}}
    @stack('scripts')

</body>
</html>