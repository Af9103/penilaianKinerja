@extends('layout.main')

@section('scripts')
<script>
    $(function () {
        $("#role").selectize();
    });

    $(function () {
        $("#line").selectize();
    });

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var toastElement = document.querySelector('.toast');
    if (toastElement) {
        var toast = new bootstrap.Toast(toastElement, { delay: 2000 }); // 3000 ms = 3 seconds
        toast.show();

        // Redirect after the toast has disappeared (3 seconds)
        setTimeout(function() {
            window.location.href = '/dashboard'; // Redirect to /dashboard
        }, 3000); // Same duration as the toast delay
    }
});
</script> 

<script>
    $(function () {
        $("#role").selectize();
    });

    // Show image preview before form submission
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('foto');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none'; // Hide the image preview if no file is selected
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deptSelect = document.getElementById('dept');
        const produksiFields = document.getElementById('produksi-fields');

        function toggleProduksiFields() {
            if (deptSelect.value === 'Produksi') {
                produksiFields.style.display = 'block';
            } else {
                produksiFields.style.display = 'none';
            }
        }

        // Trigger on page load (for old values)
        toggleProduksiFields();

        // Trigger on change
        deptSelect.addEventListener('change', toggleProduksiFields);
    });

$(function () {
    $("#tanggal_lahir").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1960:c", // dari 1960 sampai tahun sekarang
        maxDate: 0           // gak boleh lebih dari hari ini
    });
});


    $(function () {
            $("#tmt_cpns").datepicker({
                changeMonth: true,
                changeYear: true,
            });
        });

    $(function () {
            $("#tgl_sk_cpns").datepicker({
                changeMonth: true,
                changeYear: true,
            });
        });
</script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                minimumResultsForSearch: 0 // biar search bar selalu muncul
            });
        });

    $(function () {
        $("#agama").selectize();
    });

    $(function () {
        $("#status_pernikahan").selectize();
    });
    
    $(function () {
        $("#gol").selectize();
    });

    $(function () {
        $("#jenis_jabatan").selectize();
    });

    $(function () {
        $("#tingkat_pendidikan").selectize();
    });
    </script>


@endsection

@section('isi')
<div class="pagetitle">
    <h1>Tambah Pegawai</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('pegawai') }}">Daftar Karyawan</a></li>
            <li class="breadcrumb-item active">Tambah Pegawai</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <!-- Added justify-content-center to center the content -->
                <!-- Recent Sales -->
                <div class="col-8">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Form Tambah Pegawai</h5> <!-- Title for the form -->

                            @if(session()->has('success'))
                            <div class="toast position-fixed top-50 start-50 translate-middle p-3" role="alert"
                            aria-live="assertive" aria-atomic="true" style="z-index: 11">
                              <div class="toast-header">
                                <strong class="me-auto">Sukses</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                              </div>
                              <div class="toast-body">
                                {{ session('success') }}
                              </div>
                            </div>
                            @endif
                            <form method="POST" action="/user/tambah" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP<span style="color: red;">*</span></label>
                                    <input type="number" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                                    @error('nip')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap<span style="color: red;">*</span></label>
                                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span style="color: red;">*</span></label>
                                    <input type="text" id="nik" name="nik" 
                                        class="form-control @error('nik') is-invalid @enderror" 
                                        value="{{ old('nik') }}" maxlength="16">
                                    @error('nik')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">E-Mail<span style="color: red;">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP<span style="color: red;">*</span></label>
                                    <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gelar_depan" class="form-label">Gelar Depan</label>
                                    <input type="text" id="gelar_depan" name="gelar_depan" class="form-control @error('gelar_depan') is-invalid @enderror" value="{{ old('gelar_depan') }}">
                                    @error('gelar_depan')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                                    <input type="text" id="gelar_belakang" name="gelar_belakang" class="form-control @error('gelar_belakang') is-invalid @enderror" value="{{ old('gelar_belakang') }}">
                                    @error('gelar_belakang')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir<span style="color: red;">*</span></label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir<span style="color: red;">*</span></label>
                                    <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" autocomplete="off">
                                    @error('tanggal_lahir')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin <span style="color: red;">*</span></label><br>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                            type="radio" 
                                            name="jenis_kelamin" 
                                            id="laki" 
                                            value="L" 
                                            {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="laki">Laki-Laki</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                            type="radio" 
                                            name="jenis_kelamin" 
                                            id="perempuan" 
                                            value="P" 
                                            {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>

                                    @error('jenis_kelamin')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama <span style="color: red;">*</span></label>
                                    <select id="agama" name="agama" 
                                        class="form-control @error('agama') is-invalid @enderror" data-live-search="true">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status_pernikahan" class="form-label">Status Pernikahan <span style="color: red;">*</span></label>
                                    <select id="status_pernikahan" name="status_pernikahan" 
                                            class="form-control @error('status_pernikahan') is-invalid @enderror">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                        <option value="Cerai" {{ old('status_pernikahan') == 'Cerai' ? 'selected' : '' }}>Cerai Hidup</option>
                                    </select>

                                    @error('status_pernikahan')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="tgl_sk_cpns" class="form-label">Tanggal SK CPNS<span style="color: red;">*</span></label>
                                    <input type="text" id="tgl_sk_cpns" name="tgl_sk_cpns" class="form-control @error('tgl_sk_cpns') is-invalid @enderror" value="{{ old('tgl_sk_cpns') }}" autocomplete="off">
                                    @error('tgl_sk_cpns')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status CPNS PNS <span style="color: red;">*</span></label><br>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('status_pns') is-invalid @enderror" 
                                            type="radio" 
                                            name="status_pns" 
                                            id="C" 
                                            value="C" 
                                            {{ old('status_pns') == 'C' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="laki">CPNS</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('status_pns') is-invalid @enderror" 
                                            type="radio" 
                                            name="status_pns" 
                                            id="P" 
                                            value="P" 
                                            {{ old('status_pns') == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">PNS</label>
                                    </div>

                                    @error('status_pns')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_sk_cpns" class="form-label">Nomor SK CPNS<span style="color: red;">*</span></label>
                                    <input type="text" id="no_sk_cpns" name="no_sk_cpns" class="form-control @error('no_sk_cpns') is-invalid @enderror" value="{{ old('no_sk_cpns') }}">
                                    @error('no_sk_cpns')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tmt_cpns" class="form-label">TMT CPNS<span style="color: red;">*</span></label>
                                    <input type="text" id="tmt_cpns" name="tmt_cpns" class="form-control @error('tmt_cpns') is-invalid @enderror" value="{{ old('tmt_cpns') }}" autocomplete="off">
                                    @error('tmt_cpns')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gol" class="form-label">Golongan <span style="color: red;">*</span></label>
                                    <select id="gol" name="gol" 
                                            class="form-control @error('gol') is-invalid @enderror">
                                        <option value="">-- Pilih Golongan --</option>
                                        <option value="I/a" {{ old('gol') == 'I/a' ? 'selected' : '' }}>I/a</option>
                                        <option value="I/b" {{ old('gol') == 'I/b' ? 'selected' : '' }}>I/b</option>
                                        <option value="I/c" {{ old('gol') == 'I/c' ? 'selected' : '' }}>I/c</option>
                                        <option value="I/d" {{ old('gol') == 'I/d' ? 'selected' : '' }}>I/d</option>
                                        <option value="II/a" {{ old('gol') == 'II/a' ? 'selected' : '' }}>II/a</option>
                                        <option value="II/b" {{ old('gol') == 'II/b' ? 'selected' : '' }}>II/b</option>
                                        <option value="II/c" {{ old('gol') == 'II/c' ? 'selected' : '' }}>II/c</option>
                                        <option value="II/d" {{ old('gol') == 'II/d' ? 'selected' : '' }}>II/d</option>
                                        <option value="III/a" {{ old('gol') == 'III/a' ? 'selected' : '' }}>III/a</option>
                                        <option value="III/b" {{ old('gol') == 'III/b' ? 'selected' : '' }}>III/b</option>
                                        <option value="III/c" {{ old('gol') == 'III/c' ? 'selected' : '' }}>III/c</option>
                                        <option value="III/d" {{ old('gol') == 'III/d' ? 'selected' : '' }}>III/d</option>
                                        <option value="IV/a" {{ old('gol') == 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                        <option value="IV/b" {{ old('gol') == 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                        <option value="IV/c" {{ old('gol') == 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                        <option value="IV/d" {{ old('gol') == 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                        <option value="IV/e" {{ old('gol') == 'IV/e' ? 'selected' : '' }}>IV/e</option>
                                    </select>

                                    @error('gol')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_jabatan" class="form-label">Jenis Jabatan <span style="color: red;">*</span></label>
                                    <select id="jenis_jabatan" name="jenis_jabatan" 
                                            class="form-control @error('jenis_jabatan') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis Jabatan --</option>
                                        <option value="Struktural" {{ old('jenis_jabatan') == 'Struktural' ? 'selected' : '' }}>Struktural</option>
                                        <option value="Fungsional" {{ old('jenis_jabatan') == 'Fungsional' ? 'selected' : '' }}>Fungsional</option>
                                        <option value="Pelaksana" {{ old('jenis_jabatan') == 'Pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                                    </select>

                                    @error('jenis_jabatan')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jabatan_nama" class="form-label">Jabatan Nama<span style="color: red;">*</span></label>
                                    <input type="text" id="jabatan_nama" name="jabatan_nama" class="form-control @error('jabatan_nama') is-invalid @enderror" value="{{ old('jabatan_nama') }}">
                                    @error('jabatan_nama')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tingkat_pendidikan" class="form-label">Tingkat Pendidikan <span style="color: red;">*</span></label>
                                    <select id="tingkat_pendidikan" name="tingkat_pendidikan" 
                                            class="form-control @error('tingkat_pendidikan') is-invalid @enderror">
                                        <option value="">-- Pilih Tingkat Pendidikan --</option>
                                        <option value="SD" {{ old('tingkat_pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('tingkat_pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA/SMK" {{ old('tingkat_pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D1" {{ old('tingkat_pendidikan') == 'D1' ? 'selected' : '' }}>Diploma I (D1)</option>
                                        <option value="D2" {{ old('tingkat_pendidikan') == 'D2' ? 'selected' : '' }}>Diploma II (D2)</option>
                                        <option value="D3" {{ old('tingkat_pendidikan') == 'D3' ? 'selected' : '' }}>Diploma III (D3)</option>
                                        <option value="D4" {{ old('tingkat_pendidikan') == 'D4' ? 'selected' : '' }}>Diploma IV (D4)</option>
                                        <option value="S1" {{ old('tingkat_pendidikan') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                        <option value="S2" {{ old('tingkat_pendidikan') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                        <option value="S3" {{ old('tingkat_pendidikan') == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                                    </select>

                                    @error('tingkat_pendidikan')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pend" class="form-label">Pendidikan<span style="color: red;">*</span></label>
                                    <input type="text" id="pend" name="pend" class="form-control @error('pend') is-invalid @enderror" value="{{ old('pend') }}">
                                    @error('pend')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span style="color: red;">*</span></label>
                                    <input type="text" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role <span style="color: red;">*</span></label><br>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('role') is-invalid @enderror" 
                                            type="radio" 
                                            name="role" 
                                            id="Admin" 
                                            value="Admin" 
                                            {{ old('role') == 'Admin' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="laki">Admin</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('role') is-invalid @enderror" 
                                            type="radio" 
                                            name="role" 
                                            id="PNS" 
                                            value="PNS" 
                                            {{ old('role') == 'PNS' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">PNS</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('role') is-invalid @enderror" 
                                            type="radio" 
                                            name="role" 
                                            id="Atasan" 
                                            value="Atasan" 
                                            {{ old('role') == 'Atasan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">Atasan</label>
                                    </div>

                                    @error('role')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                    <img id="imagePreview" src="" alt="Image Preview" style="max-width: 200px; display: none; margin-top: 15px;">
                                </div>

                                 </div>
                            </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div><!-- End Recent Sales -->
                    </div>
                </div><!-- End Left side columns -->
            </div>
        </div>

</section>
@endsection