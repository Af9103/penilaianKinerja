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

<script>
$(document).ready(function() {
    $('#tahun').change(function() {
        let tahun = $(this).val();

        // Tampilkan spinner di tabel
        $('#hasil-table').html(`
            <tr id="spinner-row">
                <td colspan="9" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('penilaian.hasil') }}",
            type: "GET",
            data: { tahun: tahun },
            success: function(data) {
                let html = '';
                data.forEach((hasil, index) => {
                    let kategoriClass = hasil.kategori === 'Baik' ? 'bg-success' : (hasil.kategori === 'Cukup' ? 'bg-warning text-dark' : 'bg-danger');

                    html += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${hasil.user.nip}</td>
                        <td class="text-center">
                            ${hasil.user.gelar_depan ? hasil.user.gelar_depan + ' ' : ''}${hasil.user.nama}${hasil.user.gelar_belakang ? ', ' + hasil.user.gelar_belakang : ''}
                        </td>
                        <td class="text-center">${hasil.absen}</td>
                        <td class="text-center">${hasil.prestasi}</td>
                        <td class="text-center">${hasil.kinerja}</td>
                        <td class="text-center">${hasil.nilai_saw}</td>
                        <td class="text-center"><span class="badge ${kategoriClass}">${hasil.kategori}</span></td>
                        <td>
                            <div class="dropdown dropend">
                                <button class="btn dropdown-toggle btn-xs custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">Detail</button>
                                <ul class="dropdown-menu dropdown-menu-xs">
                                    <li><a class="dropdown-item btn-show-nilai" href="#" data-bs-toggle="modal" data-bs-target="#nilaiModal" data-user-id="${hasil.user_id}" data-nama="${hasil.user.nama}"><i class="bi bi-list-ul"></i> Histori Penilaian</a></li>
                                    ${hasil.tahun == new Date().getFullYear() ? `<li><a class="dropdown-item btn-edit-nilai" href="#" data-bs-toggle="modal" data-bs-target="#editModal" data-nilai-id="${hasil.id}"><i class="bi bi-pencil-square"></i> Edit Nilai</a></li>` : ''}
                                </ul>
                            </div>
                        </td>
                    </tr>`;
                });

                // Ganti spinner dengan data
                $('#hasil-table').html(html);
                $('#judul-penilaian').text(`Hasil Penilaian ${tahun}`);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan.');
                $('#spinner-row').remove();
            }
        });
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
    <h1>Hasil Penialain</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Hasil Penilaian</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <div class="row mb-3">
                            
    <div class="col-md-12 d-flex justify-content-end">
        <label for="tahun" class="me-2 align-self-center">Pilih Tahun:</label>
            <select name="tahun" id="tahun" class="form-select w-auto d-inline-block">
                @for ($i = $currentYear; $i >= $currentYear - 4; $i--)
                    <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
    </div>


        <!-- Left side columns -->
        <div class="col-md-12">
                    <ul class="nav nav-tabs">
            @if(auth()->user()->role === 'Atasan')
            <li class="nav-item">
              <a class="nav-link" href="../penilaian" style="color: green !important;" aria-current="page"
                href="penilaian">Pemberian Nilai<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link active" href="../penilaian/hasil">Hasil Penilaian<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
          </ul>
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title" id="judul-penilaian">
                        Hasil Penilaian {{ $selectedYear }}
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
                                <th scope="col" class="text-center">Aksi</th>                         
                            </tr>
                            </thead>
                            <tbody id="hasil-table">
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
                                                @php
                                                    $tahunSekarang = date('Y');
                                                @endphp

                                                @if($hasil->tahun == $tahunSekarang)
                                                    <li>
                                                        <a class="dropdown-item btn-edit-nilai" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-nilai-id="{{ $hasil->id }}">
                                                        <i class="bi bi-pencil-square"></i> Edit Nilai
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                    </table>
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
        <table class="table table-bordered">
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Penilaian</h5>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
      
      <form id="formEditNilai" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="hidden" name="id" id="nilai_id">

            <div class="form-group">
                <label>Absensi (%)</label>
                <input type="number" name="absen" id="edit_absen" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Prestasi</label>
                <input type="number" name="prestasi" id="edit_prestasi" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kinerja</label>
                <input type="number" name="kinerja" id="edit_kinerja" class="form-control" required>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>



@endsection
