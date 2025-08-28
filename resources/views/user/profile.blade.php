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
document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah URL ada hash
    var hash = window.location.hash;
    if(hash) {
        // Hapus kelas aktif di nav-link dan tab-pane
        document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('show', 'active'));

        // Aktifkan nav-link yang sesuai hash
        var tabButton = document.querySelector(`button[data-bs-target="${hash}"]`);
        if(tabButton) {
            tabButton.classList.add('active');
            var tabPane = document.querySelector(hash);
            if(tabPane) {
                tabPane.classList.add('show', 'active');
            }
        }
    }
});
</script>

<script>
    $(function () {
        $("#gol").selectize();
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


<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Profile {{ $user->nama }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>
    
    {{-- Tombol Promosikan --}}
      <a href="#" class="btn btn-primary" 
        data-toggle="modal" 
        data-target="#promosiModal{{ $nilaiUser->id }}">
          <i class="bi bi-arrow-up-circle"></i> Promosikan
      </a>
      
</div>


<section class="section dashboard">
    <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{ $user->foto ? asset('storage/foto/' . $user->foto) : ($user->jenis_kelamin == 'L' ? asset('assets/img/pp.png') : asset('assets/img/ppCewe.png')) }}" 
                  alt="Profile" class="rounded-circle img-fluid" style="max-width:200px;aspect-ratio:1/1; border-radius:50%; object-fit:cover; display:block; margin-bottom: 10px;">

              <h2>{{ $user->nama }}</h2>
              <h3>{{ $user->nip }}</h3>
              <div class="d-flex flex-column align-items-center" style="gap:5px;">
            <div style="display:flex; align-items:center; gap:8px; font-size:16px; color:#007bff;">
                <i class="bi bi-telephone-fill"></i> <!-- pastikan Bootstrap Icons tersedia -->
                <span>{{ $user->no_hp }}</span>
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:16px; color:#17a2b8;">
                <i class="bi bi-envelope-fill"></i>
                <span>{{ $user->email }}</span>
            </div>
        </div>
        {{-- <div class="mt-3 w-100 text-center">
        <a href="#" 
           class="btn btn-primary w-100">
           <i class="bi bi-arrow-up-circle"></i> Promosikan
        </a>
    </div> --}}
            </div>
          </div>

          <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title text-center">Nilai Kinerja {{ $user->nama }} Tahun {{ \Carbon\Carbon::now()->year }}</h5>
            <!-- Konten tambahan -->
            <div style="height: 257px; margin-left: 0; padding: 20px;">
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

                 {{-- <div class="text-center mt-1">
                  <a href="#" 
                    class="btn btn-success">
                    <i class="bi bi-award"></i> Promosikan
                  </a>
              </div> --}}

        </div>
        
    </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">History Penilaian</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">History TMT</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="fst-italic">
                      {{ ($user->gelar_depan ? $user->gelar_depan . ' ' : '') . $user->nama . ($user->gelar_belakang ? ', ' . $user->gelar_belakang : '') }}  
                      adalah Pegawai Negeri Sipil ({{ $user->status_pns == 'C' ? 'Calon PNS' : 'PNS' }}) dengan jabatan {{ $user->jenis_jabatan }} - {{ $user->jabatan_nama }}.  
                      Memiliki pendidikan {{ $user->tingkat_pendidikan }} ({{ $user->pend }}). Golongan: {{ $user->gol }}.  
                      Berdedikasi dalam menjalankan tugas dan memberikan pelayanan yang profesional.
                    </p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"> {{ ($user->gelar_depan ? $user->gelar_depan . ' ' : '') . $user->nama . ($user->gelar_belakang ? ', ' . $user->gelar_belakang : '') }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">NIK</div>
                    <div class="col-lg-9 col-md-8">{{ $user->nik }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Tempat, Tanggal Lahir</div>
                    <div class="col-lg-9 col-md-8">{{ $user->tempat_lahir }}, {{ \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') }} ({{ \Carbon\Carbon::parse($user->tanggal_lahir)->age }} Tahun)</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                    <div class="col-lg-9 col-md-8">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Agama</div>
                    <div class="col-lg-9 col-md-8">{{ $user->agama }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Status Pernikahan</div>
                    <div class="col-lg-9 col-md-8">{{ $user->status_pernikahan }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Status CPNS PNS</div>
                    <div class="col-lg-9 col-md-8">{{ $user->status_pns == 'C' ? 'CPNS' : ($user->jenis_kelamin == 'P' ? 'PNS' : '-') }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">No SK CPNS</div>
                    <div class="col-lg-9 col-md-8">{{ $user->no_sk_cpns }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Tanggal SK CPNS</div>
                    <div class="col-lg-9 col-md-8">{{ $user->tgl_sk_cpns ? \Carbon\Carbon::parse($user->tgl_sk_cpns)->translatedFormat('d F Y') : '-' }}
</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Golongan</div>
                    <div class="col-lg-9 col-md-8">{{ $user->gol }}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label">Jabatan</div>
                    <div class="col-lg-9 col-md-8">Jabatan {{ $user->jenis_jabatan }} - {{ $user->jabatan_nama }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Pendidikan</div>
                    <div class="col-lg-9 col-md-8">{{ $user->tingkat_pendidikan }} - {{ $user->pend }}</div>
                  </div>

                </div>

                {{-- <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                    @forelse($penilaian as $item)
                        <div class="mb-3">
                            <strong>Absen:</strong> {{ $item->absen }} <br>
                            <strong>Prestasi:</strong> {{ $item->prestasi }} <br>
                            <strong>Kinerja:</strong> {{ $item->kinerja }} <br>
                            <strong>Nilai SAW:</strong> {{ $item->nilai_saw }} <br>
                            <strong>Kategori:</strong> 
                            <span class="@if($item->kategori == 'Baik') text-success 
                                        @elseif($item->kategori == 'Cukup') text-warning 
                                        @else text-danger @endif">
                                {{ $item->kategori }}
                            </span>
                        </div>
                    @empty
                        <p>Belum ada penilaian.</p>
                    @endforelse
                </div>  --}}

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        @if($penilaian->isEmpty())
                            <p>Belum ada penilaian.</p>
                        @else
                        {{-- <div class="d-flex justify-content-end mb-2">
                            <a href="#" class="btn btn-primary">
                                <i class="bi bi-arrow-up-circle"></i> Promosikan
                            </a>
                        </div> --}}
                            <div class="table-responsive">
                                <table class="table table-hover text-center" id="dasborTable">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Absen</th>
                                            <th>Prestasi</th>
                                            <th>Kinerja</th>
                                            <th>Nilai SAW</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penilaian as $item)
                                            <tr>
                                                <td>{{ $item->tahun }}</td>
                                                <td>{{ $item->absen }}</td>
                                                <td>{{ $item->prestasi }}</td>
                                                <td>{{ $item->kinerja }}</td>
                                                <td>{{ $item->nilai_saw }}</td>
                                                <td>
                                                    <span class="badge 
                                                  {{ $item->kategori == 'Baik' ? 'bg-success' : ($item->kategori == 'Cukup' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                  {{ $item->kategori }}
                                              </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>   
                    
                    <div class="tab-pane fade pt-3" id="profile-settings">
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label "><strong>TMT CPNS</strong></div>
                          <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($user->tmt_cpns)->translatedFormat('d F Y') }}</div>
                        </div>

                        @foreach($tmtPns->sortByDesc('tmt') as $tmt)
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label">
                                  <strong>TMT PNS - {{ $tmt->golongan }}</strong>
                              </div>
                              <div class="col-lg-9 col-md-8">
                                  {{ \Carbon\Carbon::parse($tmt->tmt)->translatedFormat('d F Y') }}
                              </div>
                          </div>
                          @endforeach         
                </div>

            </div>
          </div>

        </div>
      </div>
      
      
</section>

@endsection
<div class="modal fade" id="promosiModal{{ $nilaiUser->id }}" tabindex="-1" 
     role="dialog" aria-labelledby="promosiModalLabel{{ $nilaiUser->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('spk.promosi', $nilaiUser->user_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Promosi Pegawai - {{ $nilaiUser->user->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gol" class="form-label">Golongan <span class="text-danger">*</span></label>
                        <select id="gol" name="gol" class="form-control @error('gol') is-invalid @enderror" data-live-search="true">
                            <option value="">-- Pilih Golongan --</option>
                            @php
                                $golongan = ['I/a','I/b','I/c','I/d',
                                            'II/a','II/b','II/c','II/d',
                                            'III/a','III/b','III/c','III/d',
                                            'IV/a','IV/b','IV/c','IV/d','IV/e'];
                            @endphp

                            @foreach($golongan as $g)
                                <option value="{{ $g }}" {{ $nilaiUser->user->gol == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('gol')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>