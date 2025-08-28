<div class="d-flex align-items-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center">

        <span class="d-inline" style="color: green;">SI   P E K A</span>
    </a>
</div><!-- End Logo -->


<nav class="navbar navbar-expand-lg bg-body-tertiary custom-nav">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">Home</a>
                </li>  
                
                @if(auth()->user()->role !== 'PNS')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pegawai') || Request::is('user/tambah') ? 'active' : '' }}" 
                        aria-current="page" href="/pegawai">
                            Daftar Pegawai
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role !== 'PNS')
                    <li class="nav-item">
                        @if(auth()->user()->role === 'Admin')
                            <a class="nav-link {{ Request::is('penilaian/hasil') || Request::is('penilaian') ? 'active' : '' }}" 
                            href="/penilaian/hasil">
                                Penilaian Pegawai
                            </a>
                        @elseif(auth()->user()->role === 'Atasan')
                            <a class="nav-link {{ Request::is('penilaian') || Request::is('penilaian/hasil') ? 'active' : '' }}" 
                            href="/penilaian">
                                Penilaian Pegawai
                            </a>
                        @endif
                    </li>
                @endif
                
                @if(auth()->user()->role !== 'PNS')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('rekomendasi_promosi') || Request::is('evaluasi') || Request::is('bobot') ? 'active' : '' }}" aria-current="page" href="/rekomendasi_promosi">SPK</a>
                </li> 
                @endif

                @if(auth()->user()->role !== 'PNS')
               <li class="nav-item">
                    <a class="nav-link {{ Request::is('lap-evaluasi') ? 'active' : '' }}" aria-current="page" href="/lap-evaluasi">Laporan Evaluasi</a>
                </li> 
                @endif

            </ul>
        </div>
    </div>
</nav>


<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center justify-content-between">

        <li class="nav-item me-3">
            <span class="d-flex align-items-center">
                <i class="bi bi-clock text-primary"></i>
                <span id="current-time" class="ps-2 fw-bold"></span>
            </span>
        </li><!-- End Current Time Nav Item -->

        
        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::check() ? Auth::user()->nama : 'Not Found' }}</span>
            </a><!-- End Profile Image Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{ Auth::check() ? Auth::user()->nama : 'Not Found' }}</h6>
                    <span>Jabatan {{ Auth::check() ? Auth::user()->jenis_jabatan : 'Not Found' }} - {{ Auth::check() ? Auth::user()->jabatan_nama : 'Not Found' }}</span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span></button>
                    </form>
                </li>
            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
    </ul>

</ul>
</nav>


<style>
    .custom-nav {
        margin-left: 10px;
        /* Adjust this value to move the navbar right or left */
        margin-right: 10px;
        /* Adjust this value to move the navbar left or right */
    }

    .logo span {
        margin-left: 30px;
    }

    .nav-link.active {
        color: green !important;
        font-weight: bold !important; /* Makes the text bold */
    }

    .custom-login-btn {
    background-color: #28a745;
    color: white;
    transition: all 0.3s ease;
}

.custom-login-btn:hover {
    background-color: white;
    color: green;
    outline: 1px solid green;
    transform: scale(1.05);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
}
</style>
