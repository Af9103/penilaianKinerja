@extends('layout.main')
@section('scripts')
<script>
        // Check if the 'page' query parameter is in the URL
        if (window.location.search.includes('page=')) {
            // Redirect to the same URL but without the 'page' parameter
            const url = new URL(window.location.href);
            url.searchParams.delete('page');
            window.history.replaceState({}, '', url); // Update the URL without reloading the page
        }
    </script>
    

        <script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image preview
            };

            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none'; // Hide the image preview if no file selected
        }
    });
    </script>

<script>
// Menambahkan event listener untuk perubahan pada input pencarian (search)
document.querySelector('input[name="table_search"]').addEventListener('input', function () {
    let query = this.value; // Ambil nilai pencarian dari input

    // Kirim permintaan AJAX ke server dengan query pencarian dan stok condition
    fetch(`/search?q=${query}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        let resultContainer = document.getElementById('resultContainer');
        resultContainer.innerHTML = ''; // Bersihkan hasil sebelumnya

        // Cek apakah ada hasil
        if (data.data.length === 0) {
            document.getElementById('no-results-row').style.display = 'block';
        } else {
            document.getElementById('no-results-row').style.display = 'none';

            // Loop hasil dan tampilkan setiap barang
            data.data.forEach(user => {
                let cardHtml = `
                    <div class="col-md-3 card-wrapper">
                        <div class="card" style="height: 315px; position: relative;">
                            
                            <!-- Gambar dengan link -->
                            <a href="/user/profile/${user.id}" class="text-decoration-none text-dark">
                                <img 
                                    src="${user.foto 
                                        ? '/storage/foto/' + user.foto 
                                        : (user.jenis_kelamin === 'L' 
                                            ? '/assets/img/pp.png' 
                                            : '/assets/img/ppCewe.png')}" 
                                    class="card-img-top" 
                                    alt="Foto Profil" 
                                    style="max-height: 150px; width: auto; height: auto; display: block; margin-left: auto; margin-right: auto; margin-top: 20px; object-fit: contain;">
                            </a>

                            <!-- Menu dropdown -->
                            @if(auth()->user()->role === 'Admin')
                            <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
                                <i class="bi bi-three-dots" style="color: gray; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu dropdown-menu-xs">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-mold-id="${user.id}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endif

                            <!-- Konten -->
                            <div class="card-body text-center" style="height: calc(100% - 150px);">
                                <h5 class="card-title" style="margin-top: -10px;">${user.nama}</h5>
                                <p style="margin-top: -15px;">NIP: ${user.nip}</p>
                                <p style="margin-top: -15px; margin-bottom: 0;">
                                        Jenis Jabatan: ${user.jenis_jabatan}
                                    </p>
                                    <p style="margin-top: 0; margin-bottom: 5px; font-size: 13px; color: #6c757d;">
                                        ${user.jabatan_nama}
                                    </p>
                                <span class="badge bg-primary" style="margin-top: -100px;">
                                    ${user.role}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                resultContainer.innerHTML += cardHtml;
            });
        }

        let paginationContainer = document.getElementById('paginationContainer');
        paginationContainer.innerHTML = '';
        if (data.last_page > 1) {
            let paginationHtml = '';
            for (let i = 1; i <= data.last_page; i++) {
                paginationHtml += `<a href="#" class="pagination-link" data-page="${i}">${i}</a>`;
            }
            paginationContainer.innerHTML = paginationHtml;
        }
    });
});
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElement = document.querySelector('.toast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, { delay: 3000 }); // 5000 ms = 5 detik
            toast.show();
        }
    });
    
</script> 

</script>

@endsection

@section('isi')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Daftar Pegawai</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
                <div class="row">


                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 15px;">
                                    Daftar Pegawai
                                    @if(auth()->user()->role === 'Admin')
                                    <a href="user/tambah" class="btn btn-primary float-end">
                                        <i class="bi bi-plus-circle"></i> Tambah Pegawai
                                    </a>
                                    @endif
                                </h5>

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

                                <!-- Search Input -->
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" name="table_search" class="form-control mb-3" placeholder="Cari Nama / NIP Pegawai...">
                                    </div>
                                </div>
                                
                                    

                                <div class="row" id="resultContainer">
                                    @foreach ($users as $user)
                                    <div class="col-md-3 card-wrapper">
                                        <a href="{{ url('user/profile/' . $user->id) }}" class="text-decoration-none text-dark">
                                        <div class="card" style="height: 315px; position: relative;">
                                            <!-- Gambar -->
                                            <img 
                                                src="{{ $user->foto 
                                                        ? asset('storage/foto/' . $user->foto) 
                                                        : ($user->jenis_kelamin == 'L' 
                                                            ? asset('assets/img/pp.png') 
                                                            : asset('assets/img/ppCewe.png')) }}" 
                                                class="card-img-top" 
                                                alt="Foto Profil" 
                                                style="max-height: 150px; width: auto; height: auto; display: block; margin-left: auto; margin-right: auto; margin-top: 20px; object-fit: contain;">

                                                </a>
                                            
                                            <!-- Menu dropdown -->
                                            @if(auth()->user()->role === 'Admin')
                                            <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
                                                <i class="bi bi-three-dots" style="color: gray; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                <ul class="dropdown-menu dropdown-menu-xs">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                    data-mold-id="{{ $user->id }}">
                                                    <i class="bi bi-trash"></i> Hapus</a>
                                                </li>
                                                    
                                                </ul>
                                            </div>
                                            @endif
                                            <!-- Konten -->
                                            <div class="card-body text-center" style="height: calc(100% - 150px);">
                                                <h5 class="card-title" style="margin-top: -10px;">
                                                    {{ \Illuminate\Support\Str::limit($user->nama, 26, '...') }}
                                                </h5>
                                                <p style="margin-top: -15px;">NIP: {{ $user->nip }}</p>
                                                <p style="margin-top: -15px; margin-bottom: 0;">
                                                        Jabatan {{ $user->jenis_jabatan }}
                                                    </p>
                                                    <p style="margin-top: 0; margin-bottom: 5px; font-size: 13px; color: #6c757d;">
                                                        {{ $user->jabatan_nama }}
                                                    </p>

                                                <span class="badge bg-primary"
                                                    style="margin-top: -100px;">
                                                    {{ $user->role }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Result Not Found Row -->
                                <div id="no-results-row" class="mt-4" style="display: none;">
                                    <p class="text-center">Result Not Found</p>
                                </div>                                

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-end mb-3">
                                    {{ $users->links('pagination::bootstrap-4') }}
                                </div>
                                
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this post?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                            @if(isset($user))
                            <!-- Only show the delete form if $mold is set -->
                            <form id="deleteForm" action="/user/{{ $user->id }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            @else
                            <!-- Optionally display a message or hide the delete button -->
                            <span class="text-muted">No post available to delete.</span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

    </section>

@endsection