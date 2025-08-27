@extends('layout.main')

@section('scripts')
<script>
    $(document).ready(function () {
        $('#barangMasukTable').DataTable({
            autoWidth: false,
            "language": {
                "emptyTable": "tidak ada data"
            },
            "lengthMenu": [5, 10, 15, 20, 25]
        });

        $('#barangKeluarTable').DataTable({
            autoWidth: false,
            "language": {
                "emptyTable": "tidak ada data"
            },
            "lengthMenu": [5, 10, 15, 20, 25]
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElement = document.querySelector('.toast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, { delay: 3000 }); // 3000 ms = 3 detik
            toast.show();
        }
    });
</script>

<script>
const pieData1 = {
        labels: ["Baik", "Cukup", "Kurang"],
        datasets: [{
            label: "Distribusi Kategori",
            data: [
                {{ $kategoriCount['Baik'] }},
                {{ $kategoriCount['Cukup'] }},
                {{ $kategoriCount['Kurang'] }}
            ],
            backgroundColor: ["#28a745", "#ffc107", "#dc3545"], // hijau, kuning, merah
        }],
    };

    const pieOptions = {
        responsive: true,
        plugins: {
            legend: {
                position: "bottom",
            },
            datalabels: {
                color: "#fff",
                formatter: (value, ctx) => {
                    let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    let percentage = ((value / sum) * 100).toFixed(1) + "%";
                    return percentage;
                },
            },
        },
    };

    new Chart(document.getElementById("pieChart1"), {
        type: "pie",
        data: pieData1,
        options: pieOptions,
        plugins: [ChartDataLabels], // Aktifkan plugin DataLabels
    });
</script>


@endsection

@section('isi')

@if(session()->has('loginSuccess'))
<div class="toast position-fixed" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;" role="alert" 
        aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="me-auto">Berhasil Login!!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('loginSuccess') }}
    </div>
</div>
@endif

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div style="float: right; margin-top: -25px; font-size: 16px; font-weight: bold; color: #218838;">
        Sistem Informasi Penilaian Kinerja (SI PEKA)
    </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Total Reports Card -->
                    <div class="col-xxl-3 col-md-6">
                        <a href="{{ url('user/profile/' . Auth::user()->id) }}" style="text-decoration: none; color: inherit;">
                            <div class="card shadow-sm p-3 mb-3" style="border-radius: 12px; min-height: 158px;">
                                <div class="d-flex align-items-center mb-3">
                                    <!-- Foto profil -->
                                    <img src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : (Auth::user()->jenis_kelamin == 'L' ? asset('assets/img/pp.png') : asset('assets/img/ppCewe.png')) }}" 
                                            alt="Foto Profil" 
                                            style="width:60px; aspect-ratio:1/1; border-radius:50%; object-fit:cover; display:block;">

                                    <div class="ms-3">
                                        <!-- Nama -->
                                        <h6 class="mb-0">{{ Auth::user()->nama }}</h6>
                                        <!-- NIP, Posisi & Usia -->
                                        <small class="text-muted">{{ Auth::user()->nip }} • {{ Auth::user()->jabatan_nama }} • {{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->age }} Tahun</small>
                                    </div>
                                </div>

                                <!-- Tipe pegawai -->
                                <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                            </div>
                        </a>
                    </div>


                    <div class="col-xxl-3 col-md-6">
                        @if(auth()->user()->role !== 'PNS')
                            <a href="/pegawai" class="text-decoration-none">
                        @endif
                            <!-- Tambahkan href di sini -->
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Pegawai <span>| {{ $currentYear }}</span></h5>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                             <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalPegawai }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div><!-- End Total Reports Card -->


                    <!-- Reports In Progress Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                        @if(auth()->user()->role !== 'PNS')
                            <a href="/penilaian/hasil" class="text-decoration-none">
                        @endif
                                <div class="card-body">
                                    <h5 class="card-title">Total Laporan Masuk Masuk <span>| {{ $currentYear }}</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalLaporan }}</h6>
                                            <!-- Display the total count here -->
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div><!-- End Reports In Progress Card -->

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                        @if(auth()->user()->role !== 'PNS')
                            <a href="/penilaian/hasil" class="text-decoration-none">
                        @endif
                                <div class="card-body">
                                    <h5 class="card-title">Rata-Rata Kinerja <span>| {{ $currentYear }}</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-bar-chart" 
                                            style="color: 
                                                    @switch($rataRataKategori)
                                                        @case('Baik') green @break
                                                        @case('Cukup') orange @break
                                                        @case('Kurang') red @break
                                                        @default black
                                                    @endswitch
                                            "></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 style="color: 
                                                    @switch($rataRataKategori)
                                                        @case('Baik') green @break
                                                        @case('Cukup') orange @break
                                                        @case('Kurang') red @break
                                                        @default black
                                                    @endswitch">
                                                {{ $rataRataKategori }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


            <div class="col-xxl-8 col-md-12">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Distribusi Penilaian <span>| {{ $currentYear }}</span></h5>
            <div style="max-width: 250px; margin: auto;">
                <canvas id="pieChart1"></canvas>
            </div>
        </div>
    </div>
</div><!-- End Card with Pie Chart 1 -->

<div class="col-xxl-4 col-md-12">
    <a href="{{ url('user/profile/' . Auth::user()->id) }}#profile-edit" class="text-decoration-none text-dark card-link-tab">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Nilai Kinerja Pribadi <span>| {{ $currentYear }}</span></h5>
                <div style="height: 250px; margin-left: 0; padding: 20px;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Absensi</span>
                            <span><strong>{{ $nilaiUser->absen ?? '-' }}%</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Prestasi</span>
                            <span><strong>{{ $nilaiUser->prestasi ?? '-' }}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Penilaian Kinerja</span>
                            <span><strong>{{ $nilaiUser->kinerja ?? '-' }}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Skor</span>
                            <span><strong>{{ $nilaiSAW ?? '-' }}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span>Kategori</span>
                            <strong class="{{ $kategoriClass }}">{{ $kategoriUser ?? '-' }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </a>
</div>

                    
    </section>
@endsection

