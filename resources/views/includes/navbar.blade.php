<nav class="navbar navbar-header navbar-expand navbar-light">
    {{-- Tombol toggle sidebar --}}
    <a class="sidebar-toggler" href="#">
        <span class="navbar-toggler-icon"></span>
    </a>
    
    {{-- Toggle untuk mobile --}}
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#topbarNav" aria-controls="topbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topbarNav">
        <ul class="navbar-nav ms-auto align-items-center">

            {{-- Mode Light/Dark --}}
            <li class="nav-item">
                <a class="nav-link" href="#" id="toggleTheme">
                    <i class="bi bi-moon"></i>
                </a>
            </li>

            {{-- Notifikasi --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                    <li><a class="dropdown-item" href="#">Pembayaran baru masuk</a></li>
                    <li><a class="dropdown-item" href="#">3 siswa belum bayar</a></li>
                </ul>
            </li>

            {{-- Profil User --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}" 
                         class="rounded-circle me-2" width="32" height="32" alt="avatar">
                    <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profil</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Logout
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
