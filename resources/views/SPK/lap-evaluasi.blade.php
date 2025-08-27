@extends('layout.main')

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dasborTable').DataTable({
            autoWidth: false,
            "language": {
                "emptyTable": "tidak ada data"
            },
            "lengthMenu": [5, 10, 15, 20, 25],
        });
    });

</script>

<script>
    // Pie Chart dengan nilai
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Baik', 'Cukup', 'Kurang'],
            datasets: [{
                data: [{{ $summary['baik'] }}, {{ $summary['cukup'] }}, {{ $summary['kurang'] }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#fff',
                    formatter: function(value, context) {
                        return value; // tampilkan nilai
                    },
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Bar Chart
const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Absensi', 'Prestasi', 'Kinerja'],
            datasets: [{
                label: 'Rata-rata',
                data: [{{ $avg['absen'] }}, {{ $avg['prestasi'] }}, {{ $avg['kinerja'] }}],
                backgroundColor: ['#007bff', '#17a2b8', '#6f42c1']
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    color: '#000',
                    font: { weight: 'bold', size: 12 },
                    formatter: function(value) { return value; }
                },
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>



@endsection

@section('isi')

@if(session()->has('success'))
<div class="toast position-fixed" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;" role="alert" 
        aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            {{ session('success') }}
          </div>
        </div>
@endif


<div class="pagetitle">
    <h1>Laporan Evaluasi Tahunan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Evaluasi Tahunan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <div class="row mb-3">


        <!-- Left side columns -->
        <div class="col-md-12">
                    
            <div class="card recent-sales overflow-auto">
                <div class="card">
    <div class="card-body">
        <h5 class="card-title">Laporan Evaluasi Tahun {{ $tahun }}</h5>

        {{-- 1. RINGKASAN --}}
        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="alert alert-primary">
                    Total: <strong>{{ $summary['total'] }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-success">
                    Baik: <strong>{{ $summary['baik'] }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-warning">
                    Cukup: <strong>{{ $summary['cukup'] }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-danger">
                    Kurang: <strong>{{ $summary['kurang'] }}</strong>
                </div>
            </div>
        </div>

        {{-- 2. TABEL DETAIL --}}
        <div class="row">
            {{-- 5 Pegawai Terbaik --}}
            <div class="col-6">
                <h5 class="text-success">5 Pegawai Terbaik</h5>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Absensi</th>
                            <th>Prestasi</th>
                            <th>Kinerja</th>
                            <th>Nilai Akhir</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($top5 as $hasil)
                        <tr>
                            <td>{{ $hasil->user->nama }}</td>
                            <td>{{ $hasil->absen }}</td>
                            <td>{{ $hasil->prestasi }}</td>
                            <td>{{ $hasil->kinerja }}</td>
                            <td>{{ $hasil->nilai_saw }}</td>
                            <td>
                                <span class="badge 
                                {{ $hasil->kategori == 'Baik' ? 'bg-success' : ($hasil->kategori == 'Cukup' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $hasil->kategori }}
                            </span> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 5 Pegawai Terburuk --}}
            <div class="col-6">
                <h5 class="text-danger">5 Pegawai Terburuk</h5>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Absensi</th>
                            <th>Prestasi</th>
                            <th>Kinerja</th>
                            <th>Nilai Akhir</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bottom5 as $hasil)
                        <tr>
                            <td>{{ $hasil->user->nama }}</td>
                            <td>{{ $hasil->absen }}</td>
                            <td>{{ $hasil->prestasi }}</td>
                            <td>{{ $hasil->kinerja }}</td>
                            <td>{{ $hasil->nilai_saw }}</td>
                            <td>
                                <span class="badge 
                                    {{ $hasil->kategori == 'Baik' ? 'bg-success' : ($hasil->kategori == 'Cukup' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $hasil->kategori }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    


        {{-- 3. GRAFIK --}}
        <div class="row mt-4">
            <div class="col-md-6" style="max-width: 250px; margin: auto;">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        {{-- 4. NARASI --}}
        <div class="mt-4">
            <div class="alert alert-info">
                {{ $narasi }}
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>   
</section>

@endsection
