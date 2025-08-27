<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Penilaian;
use App\Models\TmtPns;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all users from the database
        $search = $request->input('search');

        // Pass the data to the view
        return view('user.index', [
            'tittle' => 'Daftar Pegawai | SIPEKA',
            'users' => User::paginate(8)->withQueryString()
        ]);
    }

    public function show()
    {
        return view('user.tambah', [
            'tittle' => 'Tambah Pegawai | SIPEKA'
        ]);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'nama' => 'required|string|max:50',
            'gelar_depan' => 'nullable|string|max:7',
            'gelar_belakang' => 'nullable|string|max:10',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah,Cerai',
            'tgl_sk_cpns' => 'required|date',
            'nik' => 'required|digits:16|unique:users,nik',
            'no_hp' => 'required',
            'status_pns' => 'required|in:C,P',
            'no_sk_cpns' => 'required',
            'tmt_cpns' => 'required|date',
            'gol' => 'required|in:I/a,I/b,I/c,I/d,II/a,II/b,II/c,II/d,III/a,III/b,III/c,III/d,IV/a,IV/b,IV/c,IV/d,IV/e',
            'jenis_jabatan' => 'required|in:Struktural,Fungsional,Pelaksana',
            'jabatan_nama' => 'required',
            'tingkat_pendidikan' => 'required|in:SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3',
            'pend' => 'required',
            'role' => 'required',
            'password' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Store the foto in the 'public/images' directory and get the file path
            $imagePath = $request->file('foto')->store('foto', 'public');
            $validatedData['foto'] = basename($imagePath); // Store only the file name
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/pegawai')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function destroy(User $user)
    {
        if ($user->foto) {
            Storage::delete($user->foto);
        }
        User::destroy($user->id);
        return redirect('pegawai/')->with('success', 'pegawai berhasil dihapus!');
    }

    public function profile($id)
    {
        $user = User::find($id); // Mencari data berdasarkan ID
        if (!$user) {
            // Jika data tidak ditemukan, bisa memberikan notifikasi atau redirect
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Ambil data pencapaian yang sudah ada berdasarkan produksi_id
        $existingData = User::where('id', $user->id)->get();
        $penilaians = Penilaian::where('user_id', $user->id)->get();
        $tmtPns = TmtPns::where('user_id', $user->id)->get();

        $bobot = BobotKriteria::pluck('bobot', 'Kriteria')->toArray();

        // Skala maksimum tetap
        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        // Hitung nilai SAW
        foreach ($penilaians as $penilaian) {
            $nilai = 0;
            $nilai += ($penilaian->absen / $max['absen']) * $bobot['absen'];
            $nilai += ($penilaian->prestasi / $max['prestasi']) * $bobot['prestasi'];
            $nilai += ($penilaian->kinerja / $max['kinerja']) * $bobot['kinerja'];

            $penilaian->nilai_saw = round($nilai, 3);

            if ($nilai < 0.4) {
                $penilaian->kategori = "Kurang";
            } elseif ($nilai < 0.7) {
                $penilaian->kategori = "Cukup";
            } else {
                $penilaian->kategori = "Baik";
            }
        }

        return view('User.profile', [
            'tittle' => 'Profile ' . $user->nama . ' | SIPEKA',
            'user' => $user,
            'existingData' => $existingData,
            'penilaian' => $penilaians,
            'tmtPns' => $tmtPns,
        ]);
    }

    public function search(Request $request)
    {
        // Ambil parameter pencarian dan stok condition
        $query = $request->get('q');

        // Mulai query untuk mengambil barang
        $usersQuery = User::query();

        // Jika ada query pencarian (search term)
        if ($query) {
            $usersQuery->where('nama', 'like', '%' . $query . '%')
                ->orWhere('nip', 'like', '%' . $query . '%');
        }



        // Lakukan pagination dan ambil data
        $users = $usersQuery->paginate(8);

        // Return data sebagai JSON
        return response()->json($users);
    }


    public function fetchAll()
    {
        // Fetch all barang data with pagination
        $users = User::paginate(4); // Paginate 4 results per page
        return response()->json([
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'total' => $users->total()
        ]);
    }

}
