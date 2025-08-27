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
    <h1>Penilaian Kinerja</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Penilaian Kinerja</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-md-12">
                    <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="../penilaian" aria-current="page"
                href="penilaian">Pemberian Nilai<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="penilaian/hasil" style="color: green !important;">Hasil Penilaian<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
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
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $user->nip }}</td>
                                    <td class="text-center">
                                        {{ $user->gelar_depan ? $user->gelar_depan . ' ' : '' }}
                                        {{ $user->nama }}
                                        {{ $user->gelar_belakang ? ', ' . $user->gelar_belakang : '' }}
                                    </td>
                                    <td>
                                    <!-- Tombol -->
                                   <button class="custom-button" data-toggle="modal" data-target="#penilaianModal{{ $user->id }}">
                                        Penilaian
                                    </button>
                                </td>
                                </tr>

                                <div class="modal fade" id="penilaianModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="penilaianModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                
                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="penilaianModalLabel{{ $user->id }}">
                                                        Form Penilaian - {{ $user->nama }}
                                                    </h5>
                                                     <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <!-- Body (Form) -->
                                                <form action="/penilaian/store" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="absensi">Absensi (%)</label>
                                                            <input type="number" step="0.01" class="form-control" name="absen" required placeholder="99.91">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="prestasi">Prestasi (1-10)</label>
                                                            <input type="number" min="1" max="10" class="form-control" name="prestasi" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="kinerja">Penilaian Kinerja (1-10)</label>
                                                            <input type="number" min="1" max="10" class="form-control" name="kinerja" required>
                                                        </div>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>   
</section>

@endsection
