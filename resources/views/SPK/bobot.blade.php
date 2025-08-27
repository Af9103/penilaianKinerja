@extends('layout.main')

@section('scripts')
<script>
    const editBtn = document.getElementById('editBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const actionButtons = document.getElementById('actionButtons');
    const submitBtn = document.getElementById('submitBtn');
    const inputs = document.querySelectorAll('.bobot-input');

    function hitungTotal() {
        let total = 0;
        inputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });

        document.getElementById('totalBobot').textContent = total.toFixed(2);

        if (Math.abs(total - 1) > 0.001) {
            submitBtn.disabled = true;
            document.getElementById('bobotWarning').style.display = 'block';
        } else {
            submitBtn.disabled = false;
            document.getElementById('bobotWarning').style.display = 'none';
        }
    }

    // Event listener hitung total
    inputs.forEach(input => {
        input.addEventListener('input', hitungTotal);
    });

    // Kondisi awal (hitung total)
    hitungTotal();

    // Klik Edit
    editBtn.addEventListener('click', () => {
        inputs.forEach(input => input.disabled = false);
        editBtn.style.display = 'none';
        actionButtons.style.display = 'block';
        hitungTotal();
    });

    // Klik Cancel
    cancelBtn.addEventListener('click', () => {
        inputs.forEach(input => {
            input.value = input.getAttribute('data-original'); // restore nilai awal
            input.disabled = true;
        });
        editBtn.style.display = 'inline-block';
        actionButtons.style.display = 'none';
        submitBtn.disabled = true;
        document.getElementById('bobotWarning').style.display = 'none';
        hitungTotal(); // hitung ulang dengan nilai awal
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
    <h1>Daftar Pegawai</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Daftar Pegawai</li>
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
              <a class="nav-link" href="evaluasi" style="color: green !important;">Evaluasi<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link active">Bobot<span style="font-size: smaller; opacity: 0.7;"></span></a>
            </li>
          </ul>
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Bobot Kriteria</h5>

                    <form action="{{ route('bobot.update') }}" method="POST" id="bobotForm">
                        @csrf
                        @method('PUT')

                        @foreach($kriterias as $kriteria)
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">
                                    {{ $kriteria->Kriteria }}
                                </label>
                                <div class="col-sm-4">
                                    <input type="number" step="0.01" min="0" 
                                        class="form-control bobot-input" 
                                        name="bobot[{{ $kriteria->id }}]" 
                                        value="{{ $kriteria->bobot }}"
                                        data-original="{{ $kriteria->bobot }}"  {{-- simpan nilai awal --}}
                                        disabled>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-3">
                            <strong>Total Bobot: <span id="totalBobot">0</span></strong>
                            <div id="bobotWarning" class="text-danger mt-1" style="display: none;">
                                Bobot kriteria harus berjumlah <strong>1.0</strong>
                            </div>
                        </div>

                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-secondary mt-3" id="editBtn">
                            Edit Bobot
                        </button>

                        <!-- Tombol Update & Cancel (disembunyikan awalnya) -->
                        <div class="mt-3" id="actionButtons" style="display: none;">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                Update
                            </button>
                            <button type="button" class="btn btn-danger" id="cancelBtn">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   
</section>

@endsection
