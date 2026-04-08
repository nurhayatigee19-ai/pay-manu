<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">

        {{-- HEADER --}}
        <div class="sidebar-header">
            <div class="d-flex align-items-center justify-content-start">
                <img src="{{ asset('logo/logo_manu.png') }}"
                     alt="Logo"
                     style="height: 60px; width: auto; margin-right: 10px;">

                <a href="{{ route('home') }}"
                   class="fw-bold fs-5 text-decoration-none"
                   style="line-height: 1.2; color:#f1c40f;">
                    PAY MANU <br> YOSOWINANGUN
                </a>
            </div>
        </div>

        {{-- MENU --}}
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                {{-- ========================= --}}
                {{-- DASHBOARD --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.dashboard') }}" class="sidebar-link">
                                <i class="fa-solid fa-house"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'kepsek')
                        <li class="sidebar-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('kepsek.dashboard') }}" class="sidebar-link">
                                <i class="fa-solid fa-house"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- TAHUN AJAR (STAF KEUANGAN) --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.tahun_ajar.*') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.tahun_ajar.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-calendar"></i>
                                <span>Tahun Ajar</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- KELAS (HANYA STAF KEUANGAN) --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.kelas.*') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.kelas.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-chalkboard"></i>
                                <span>Kelas</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- SISWA (STAF KEUANGAN) --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.siswa.*') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.siswa.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-user-graduate"></i>
                                <span>Siswa</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- PEMBAYARAN --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.pembayaran.*') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.pembayaran.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-money-bill-wave"></i>
                                <span>Pembayaran</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- LAPORAN --}}
                {{-- ========================= --}}
                @auth
                    @if(auth()->user()->role === 'stafkeuangan')
                        <li class="sidebar-item {{ request()->routeIs('stafkeuangan.laporan.*') ? 'active' : '' }}">
                            <a href="{{ route('stafkeuangan.laporan.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-file-alt"></i>
                                <span>Laporan</span>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'kepsek')
                        <li class="sidebar-item {{ request()->routeIs('kepsek.laporan.*') ? 'active' : '' }}">
                            <a href="{{ route('kepsek.laporan.index') }}" class="sidebar-link">
                                <i class="fa-solid fa-file-alt"></i>
                                <span>Laporan</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ========================= --}}
                {{-- MANAJEMEN USER (STAF KEUANGAN) --}}
                {{-- ========================= --}}
                @auth
                @if(auth()->user()->role === 'stafkeuangan')
                <li class="sidebar-item {{ request()->routeIs('stafkeuangan.user.*') ? 'active' : '' }}">
                    <a href="{{ route('stafkeuangan.user.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-users"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                @endif
                @endauth


                {{-- ========================= --}}
                {{-- LOGOUT --}}
                {{-- ========================= --}}
                @auth
                    <li class="sidebar-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="sidebar-link btn btn-danger w-100 text-start">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</div>