<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pembayaran SPP</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>

        :root{
            --hijau:#16a34a;
            --emas:#facc15;
        }

        body{
            font-family:'Nunito',sans-serif;
            scroll-behavior:smooth;
        }

        /* Navbar */

        .navbar{
            transition:0.3s;
        }

        .navbar.scrolled{
            background:rgba(255,255,255,0.9) !important;
            backdrop-filter:blur(10px);
            box-shadow:0 4px 10px rgba(0,0,0,0.08);
        }

        .navbar.scrolled .navbar-brand,
        .navbar.scrolled .nav-link{
            color:#000 !important;
        }

        /* Hero */

        .hero{
            height:100vh;
            background:
            linear-gradient(
                rgba(0,0,0,0.55),
                rgba(0,0,0,0.35),
                rgba(0,0,0,0.55)
            ),
            url('{{ asset('image/bg_manu.jpeg') }}');
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
            display:flex;
            align-items:center;
            color:#fff;
            text-align:center;
        }

        .hero h1{
            font-weight:800;
            font-size:3rem;
            letter-spacing:1px;
        }

        .hero p{
            font-size:1.2rem;
            opacity:0.9;
        }

        .hero-btn{
            font-weight:600;
            border-radius:30px;
            transition:0.3s;
        }

        .hero-btn:hover{
            transform:translateY(-3px);
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        /* Feature */

        .feature-icon{
            font-size:3rem;
            color:var(--hijau);
        }

        .card{
            border-radius:14px;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-8px);
            box-shadow:0 15px 35px rgba(0,0,0,0.12);
        }

        /* Statistik */

        .stat{
            font-size:40px;
            font-weight:700;
            color:var(--hijau);
        }

        /* Footer */

        footer{
            background:#111;
            color:#ddd;
        }

        /* Button */

        .btn-warning{
            background:#facc15;
            border:none;
            font-weight:600;
        }

        .btn-warning:hover{
            background:#eab308;
            transform:translateY(-2px);
        }

    </style>
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg fixed-top bg-transparent">
    <div class="container">

        <a class="navbar-brand fw-bold text-white" href="#">
            <img src="{{ asset('image/logo_manu.png') }}" height="40">
            Sistem Pembayaran SPP
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link text-white" href="#fitur">Fitur</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#tentang">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-warning ms-3" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>


<!-- HERO -->

<section class="hero">
    <div class="container" data-aos="fade-up">

        <h1 class="display-4 fw-bold">
            Sistem Informasi Pembayaran SPP
        </h1>

        <p class="lead mt-3">
            Platform digital untuk mengelola pembayaran sekolah,
            data siswa, serta laporan keuangan secara cepat,
            transparan, dan efisien.
        </p>

    </div>
</section>


<!-- FITUR -->

<section id="fitur" class="py-5">
    <div style="height:80px"></div>
    <div class="container">

        <h2 class="text-center mb-5 fw-bold" data-aos="fade-up">
            Fitur Utama Sistem
        </h2>

        <div class="row g-4">

            <div class="col-md-4" data-aos="zoom-in">

                <div class="card border-0 shadow-sm h-100 text-center p-4">

                    <i class="bi bi-cash-stack feature-icon"></i>

                    <h5 class="mt-3">Pembayaran SPP</h5>

                    <p>
                        Proses pembayaran lebih cepat dan tercatat otomatis
                        dalam sistem keuangan sekolah.
                    </p>

                </div>

            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">

                <div class="card border-0 shadow-sm h-100 text-center p-4">

                    <i class="bi bi-people-fill feature-icon"></i>

                    <h5 class="mt-3">Manajemen Siswa</h5>

                    <p>
                        Kelola data siswa, kelas, dan informasi akademik
                        secara lebih terstruktur.
                    </p>

                </div>

            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">

                <div class="card border-0 shadow-sm h-100 text-center p-4">

                    <i class="bi bi-bar-chart-line feature-icon"></i>

                    <h5 class="mt-3">Laporan Keuangan</h5>

                    <p>
                        Laporan pembayaran, tunggakan, dan statistik
                        dapat diakses dengan cepat dan akurat.
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>


<!-- STATISTIK -->

<section class="py-5 bg-light">

    <div class="container">

        <div class="row text-center">

            <div class="col-md-4" data-aos="fade-up">

                <div class="stat">500+</div>
                <p>Siswa Aktif</p>

            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">

                <div class="stat">20+</div>
                <p>Kelas</p>

            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">

                <div class="stat">1000+</div>
                <p>Transaksi Pembayaran</p>

            </div>

        </div>

    </div>

</section>


<!-- TENTANG -->

<section id="tentang" class="py-5">

    <div class="container" data-aos="fade-right">

        <h2 class="text-center mb-4 fw-bold">
            Tentang Aplikasi
        </h2>

        <p class="text-center mx-auto" style="max-width:700px">

            Aplikasi Sistem Informasi Pembayaran SPP dirancang
            untuk membantu sekolah dalam mengelola pembayaran
            siswa secara digital. Dengan sistem ini proses
            administrasi menjadi lebih cepat, transparan,
            dan efisien.

        </p>

    </div>

</section>


<!-- FOOTER -->

<footer class="py-4">

    <div class="container text-center">

        <p class="fw-bold mb-1">
            Sistem Informasi Pembayaran SPP
        </p>

        <p class="mb-0">
            © {{ date('Y') }} Madrasah Aliyah Nahdlatul Ulama
        </p>

        <small class="text-secondary">
            Sistem manajemen pembayaran sekolah berbasis web
        </small>

    </div>

</footer>


<!-- JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>

    AOS.init({
        duration:1000,
        once:true
    });

    window.addEventListener("scroll",function(){

        const navbar=document.querySelector(".navbar");

        if(window.scrollY>50){
            navbar.classList.add("scrolled");
        }else{
            navbar.classList.remove("scrolled");
        }

    });

</script>

</body>
</html>
