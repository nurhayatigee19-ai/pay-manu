<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- FontAwesome (opsional) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- CSS Laravel --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<div class="d-flex">
    {{-- Sidebar --}}
    <div class="bg-white shadow-sm p-3" style="width: 250px; min-height: 100vh;">
        <h4 class="fw-bold mb-4 text-primary">PAY MANU YOSOWINANGUN</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ url('/dashboard') }}" class="nav-link text-dark">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ url('/kelas') }}" class="nav-link text-dark">
                    <i class="bi bi-folder2-open me-2"></i> Kelas
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ url('/siswa') }}" class="nav-link text-dark">
                    <i class="bi bi-people me-2"></i> Siswa
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ url('/pembayaran') }}" class="nav-link text-dark">
                    <i class="bi bi-wallet2 me-2"></i> Pembayaran
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ url('/laporan') }}" class="nav-link text-dark">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan
                </a>
            </li>
        </ul>
        <div class="mt-4">
            <a href="{{ route('logout') }}" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>
    </div>

    {{-- Konten utama --}}
    <div class="flex-grow-1 p-4">
        @yield('content')
        <footer class="text-center mt-5 text-muted">
            <small>2025 &copy; MA NU YOSOWINANGUN</small>
        </footer>
    </div>
</div>

{{-- JS Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
