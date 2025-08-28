@extends('layout.main')

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dasborTable').DataTable({
            autoWidth: false,
            "language": {
                "emptyTable": "tidak ada data"
            },
            "lengthMenu": [10, 20, 50],
        });
    });

</script>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tambahBarangModal = new bootstrap.Modal(document.getElementById('partModal'));
            tambahBarangModal.show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElement = document.querySelector('.toast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, { delay: 3000 }); // 5000 ms = 5 detik
            toast.show();
        }
    });
    
</script> 

<script>
$(document).on("click", ".btn-show-nilai", function() {
    var userId = $(this).data("user-id");

    // Kosongkan dulu tabel
    $("#nilaiBody").html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

    // Panggil route yang ambil histori penilaian
    $.ajax({
        url: "/penilaian/histori/" + userId,
        type: "GET",
        success: function(res) {
            if (res.length > 0) {
                var rows = "";
                $.each(res, function(i, val) {
                    rows += "<tr>" +
                                "<td>" + val.tahun + "</td>" +
                                "<td>" + val.absen + "%</td>" +
                                "<td>" + val.prestasi + "</td>" +
                                "<td>" + val.nilai_saw + "</td>" +
                                "<td>" + val.kategori + "</td>" +
                            "</tr>";
                });
                $("#nilaiBody").html(rows);
            } else {
                $("#nilaiBody").html('<tr><td colspan="5" class="text-center">Belum ada data</td></tr>');
            }
        },
        error: function() {
            $("#nilaiBody").html('<tr><td colspan="5" class="text-center text-danger">Gagal mengambil data</td></tr>');
        }
    });
});
</script>

<script>
$(document).on("click", ".btn-edit-nilai", function() {
    var id = $(this).data("nilai-id");

    $("#formEditNilai")[0].reset();

    $.ajax({
        url: "/penilaian/" + id + "/edit-data", // pakai route baru
        type: "GET",
        success: function(res) {
            $("#nilai_id").val(res.id);
            $("#edit_absen").val(res.absen);
            $("#edit_prestasi").val(res.prestasi);
            $("#edit_kinerja").val(res.kinerja);

            $("#formEditNilai").attr("action", "/penilaian/" + res.id);
        }
    });
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
    <h1>Daftar Pegawai Yang Perlu Dievaluasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Evaluasi Pegawai</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <div class="row mb-3">


        <!-- Left side columns -->
        <div class="col-md-12">
                    <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="rekomendasi_promosi" style="color: green !important;" aria-current="page"
                href="penilaian">Rekomendasi Promosi<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="evaluasi">Evaluasi<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            @if(auth()->user()->role === 'Admin')
            <li class="nav-item">
              <a class="nav-link" href="bobot" style="color: green !important;">Bobot<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            @endif
          </ul>
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Daftar Pegawai                                  
                    </h5>
                                                  
                    <table class="table table-hover text-center" id="dasborTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">NIP</th>
                                <th scope="col" class="text-center">Nama Lengkap</th>                         
                                <th scope="col" class="text-center">Absensi</th>                         
                                <th scope="col" class="text-center">Prestasi</th>                         
                                <th scope="col" class="text-center">Penilaian Kinerja</th>                         
                                <th scope="col" class="text-center">Skor SPK</th>                         
                                <th scope="col" class="text-center">Kategori</th>                                                
                                <th scope="col" class="text-center">Saran pengembangan</th>                                                
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasils as $hasil)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $hasil->user->nip }}</td>
                                    <td class="text-center">
                                        {{ $hasil->user->gelar_depan ? $hasil->gelar_depan . ' ' : '' }}
                                        {{ $hasil->user->nama }}
                                        {{ $hasil->user->gelar_belakang ? ', ' . $hasil->user->gelar_belakang : '' }}
                                    </td>
                                    <td class="text-center">{{ $hasil->absen }}</td>
                                    <td class="text-center">{{ $hasil->prestasi }}</td>
                                    <td class="text-center">{{ $hasil->kinerja }}</td>
                                    <td class="text-center">{{ $hasil->nilai_saw }}</td>
                                    <td class="text-center"><span class="badge 
                                        {{ $hasil->kategori == 'Baik' ? 'bg-success' : ($hasil->kategori == 'Cukup' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ $hasil->kategori }}
                                    </span>
                                    </td>
                                    <td>
                                        @php
                                            $saran = [];

                                            if ($hasil->absen < 80) {
                                                $saran[] = "Perlu peningkatan disiplin & manajemen waktu.";
                                            }

                                            if ($hasil->prestasi < 70) {
                                                $saran[] = "Dorong pencapaian target, beri motivasi & coaching.";
                                            }

                                            if ($hasil->kinerja < 70) {
                                                $saran[] = "Butuh pelatihan teknis/soft skill sesuai bidang.";
                                            }

                                            if (empty($saran)) {
                                                $saran[] = "Pertahankan kinerja, bisa dipertimbangkan untuk promosi.";
                                            }
                                        @endphp

                                        <ul class="text-start mb-0">
                                            @foreach ($saran as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                    </table>

                    <br>
                   
                        <div class="alert alert-warning">                   
                            <h6><strong>Catatan :</strong></h6>
                            <p>
                                Berdasarkan hasil penilaian kinerja Tahun {{ date('Y') }}, performa karyawan yang bersangkutan masih berada di bawah standar yang diharapkan. Hal ini menjadi pertimbangan dalam proses evaluasi promosi maupun pengembangan karier selanjutnya.
                            </p>
                            <p>
                                Catatan ini merupakan hasil evaluasi yang dihasilkan oleh sistem secara otomatis, dan bukan merupakan keputusan final. Keputusan akhir tetap ditetapkan oleh pihak yang berwenang.
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>   
</section>

@endsection
