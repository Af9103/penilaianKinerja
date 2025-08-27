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

{{-- <script>
    $(document).ready(function() {
        $('#historiTable').DataTable({
            autoWidth: false,
            "language": {
                "emptyTable": "tidak ada data"
            },
            "lengthMenu": [5, 10, 15, 20, 25],
        });
    });
</script> --}}

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
    var nama   = $(this).data("nama"); 

    // set judul modal
    $("#namaPegawai").text(nama);

    // Kosongkan dulu tabel
    $("#nilaiBody").html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

    // Panggil route yang ambil histori penilaian
    $.ajax({
        url: "/penilaian/histori/" + userId,
        type: "GET",
        success: function(res) {
            var rows = "";
            if (res.length > 0) {
                $.each(res, function(i, val) {
                    rows += "<tr>" +
                                "<td>" + val.tahun + "</td>" +
                                "<td>" + val.absen + "%</td>" +
                                "<td>" + val.prestasi + "</td>" +
                                "<td>" + val.nilai_saw + "</td>" +
                                "<td>" + 
                                "<span class='badge " + 
                                    (val.kategori == 'Baik' ? "bg-success" : 
                                    (val.kategori == 'Cukup' ? "bg-warning text-dark" : "bg-danger")) + 
                                "'>" + val.kategori + "</span>" + 
                            "</td>"
                            "</tr>";
                });
                $("#nilaiBody").html(rows);
            } else {
                $("#nilaiBody").html('<tr><td colspan="5" class="text-center">Belum ada data</td></tr>');
            }

            // Inisialisasi DataTable setelah data siap
            $("#historiTable").DataTable({
                destroy: true, // supaya bisa di re-init
                autoWidth: false,
                "language": {
                    "emptyTable": "tidak ada data"
                },
                "lengthMenu": [4, 10, 15, 20, 25]
            });
        },
        error: function() {
            $("#nilaiBody").html('<tr><td colspan="5" class="text-center text-danger">Gagal mengambil data</td></tr>');
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
    <h1>Daftar Pegawai Yang Direkomendasikan Untuk Promosi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Rekomendasi Promosi</li>
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
              <a class="nav-link active" href="promosi" aria-current="page"
                href="penilaian">Rekomendasi Promosi<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="evaluasi" style="color: green !important;">Evaluasi<span style="font-size: smaller; opacity: 0.7;"></span></a>
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
                                <th scope="col" class="text-center">TMT PNS</th>                         
                                <th scope="col" class="text-center">Absensi</th>                         
                                <th scope="col" class="text-center">Prestasi</th>                         
                                <th scope="col" class="text-center">Penilaian Kinerja</th>                         
                                <th scope="col" class="text-center">Skor SPK</th>                         
                                <th scope="col" class="text-center">Kategori</th>                         
                                <th scope="col" class="text-center">Aksi</th>                         
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasils as $hasil)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $hasil->user->nip }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($hasil->user->tmt_pns)->format('d M y') }}</td>
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
                                    {{-- <td>
                                    <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#promosiModal{{ $hasil->id }}">
                                        Promosi
                                    </button>
                                </td>   --}}
                                <td>
                                        <div class="dropdown dropend">
                                            <button class="btn dropdown-toggle btn-xs custom-dropdown"
                                                type="button" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Detail
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-xs"
                                                aria-labelledby="dropdownMenuButton">
                                                
                                                <!-- Pass the mold ID to the modal -->
                                                <li>
                                                        <a class="dropdown-item btn-show-nilai" href="#" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#nilaiModal" 
                                                        data-user-id="{{ $hasil->user_id }}"
                                                        data-nama="{{ $hasil->user->nama }}">
                                                        <i class="bi bi-list-ul"></i> Histori Penilaian
                                                        </a>
                                                    </li>
                                                    @if(auth()->user()->role === 'Atasan')
                                                <li>
                                                    <a class="dropdown-item btn-edit-nilai" href="#"
                                                    data-toggle="modal"
                                                    data-target="#promosiModal{{ $hasil->id }}">
                                                    <i class="bi bi-pencil-square"></i> Promosi
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td> 
                                </tr>

                                <div class="modal fade" id="promosiModal{{ $hasil->id }}" tabindex="-1" role="dialog" aria-labelledby="promosiModalLabel{{ $hasil->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <form action="{{ route('spk.promosi', $hasil->user_id) }}" method="POST">
                                          @csrf
                                          @method('PUT')

                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title">Promosi Pegawai - {{ $hasil->user->nama }}</h5>
                                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              
                                              <div class="modal-body">
                                                  <div class="mb-3">
                                                      <label for="gol" class="form-label">Golongan <span style="color: red;">*</span></label>
                                                      <select id="gol" name="gol" class="form-control @error('gol') is-invalid @enderror">
                                                        <option value="">-- Pilih Golongan --</option>
                                                        @php
                                                            $golongan = ['I/a','I/b','I/c','I/d',
                                                                        'II/a','II/b','II/c','II/d',
                                                                        'III/a','III/b','III/c','III/d',
                                                                        'IV/a','IV/b','IV/c','IV/d','IV/e'];
                                                        @endphp

                                                        @foreach($golongan as $g)
                                                            <option value="{{ $g }}" {{ $hasil->user->gol == $g ? 'selected' : '' }}>{{ $g }}</option>
                                                        @endforeach
                                                    </select>

                                                      @error('gol')
                                                          <div class="text-danger mt-2">{{ $message }}</div>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                  <button type="submit" class="btn btn-primary">Simpan</button>
                                              </div>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                  
                                @endforeach
                                
                            </tbody>
                    </table>
<br>
                                   
                        <div class="alert alert-info">                   
                            <h6><strong>Catatan :</strong></h6>
                            <p>
                                Rekomendasi promosi ini diberikan karena pengangkatan karyawan didasarkan pada penilaian kinerja serta riwayat kepangkatan. Berdasarkan data, TMT kenaikan pangkat terakhir karyawan yang bersangkutan telah lebih dari 4 tahun, dan hasil penilaiannya menunjukkan kategori baik.
                            </p>
                            <p>
                                Catatan ini merupakan rekomendasi yang dihasilkan oleh sistem secara otomatis, dan bukan merupakan keputusan final. Keputusan akhir tetap ditetapkan oleh pihak yang berwenang.
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>   
</section>

<div class="modal fade" id="nilaiModal" tabindex="-1" role="dialog" aria-labelledby="nilaiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nilaiModalLabel">Histori Penilaian - <span id="namaPegawai"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover text-center" id="historiTable">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Absensi</th>
                    <th>Prestasi</th>
                    <th>Nilai SAW</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody id="nilaiBody">
                <tr><td colspan="5" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
