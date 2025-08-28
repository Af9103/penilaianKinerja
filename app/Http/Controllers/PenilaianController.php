<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Penilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function show()
    {
        // Fetch all users from the database
        $year = date('Y'); // tahun sekarang

        $users = User::whereNotIn('id', function ($query) use ($year) {
            $query->select('user_id')
                ->from('penilaian')
                ->where('tahun', $year);
        })->get();

        // Pass the data to the view
        return view('penilaian.index', [
            'tittle' => 'Penilaian Kinerja | SIPEKA',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'absen' => 'required|numeric|min:0|max:100',
            'prestasi' => 'required|integer|min:1|max:10',
            'kinerja' => 'required|integer|min:1|max:10',
        ]);

        Penilaian::create([
            'user_id' => $request->user_id,
            'absen' => $request->absen,
            'prestasi' => $request->prestasi,
            'kinerja' => $request->kinerja,
            'tahun' => date('Y'),
            'oleh' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan!');
    }

    // Controller
    public function hasil(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $selectedYear = $request->input('tahun', $currentYear);
        $kategori = $request->input('kategori');

        $hasils = Penilaian::with('user', 'olehuser')
            ->where('tahun', $selectedYear)
            ->get();

        // Bobot
        $bobot = BobotKriteria::pluck('bobot', 'Kriteria')->toArray();

        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        foreach ($hasils as $hasil) {
            $nilai = 0;
            $nilai += ($hasil->absen / $max['absen']) * $bobot['absen'];
            $nilai += ($hasil->prestasi / $max['prestasi']) * $bobot['prestasi'];
            $nilai += ($hasil->kinerja / $max['kinerja']) * $bobot['kinerja'];

            $hasil->nilai_saw = round($nilai, 3);

            if ($nilai < 0.4) {
                $hasil->kategori = "Kurang";
            } elseif ($nilai < 0.7) {
                $hasil->kategori = "Cukup";
            } else {
                $hasil->kategori = "Baik";
            }
        }

        // Filter berdasarkan kategori kalau ada
        if ($kategori) {
            $hasils = $hasils->filter(function ($item) use ($kategori) {
                return $item->kategori === $kategori;
            })->values();
        }

        if ($request->ajax()) {
            return response()->json($hasils);
        }

        return view('penilaian.hasil', [
            'tittle' => 'Hasil Penilaian | SIPEKA',
            'hasils' => $hasils,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function histori($user_id)
    {
        $hasils = Penilaian::with('olehUser')
            ->where('user_id', $user_id)
            ->orderBy('tahun', 'desc')
            ->get();

        $bobot = [
            'absen' => 0.3,
            'prestasi' => 0.3,
            'kinerja' => 0.4,
        ];

        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        foreach ($hasils as $hasil) {
            $nilai = 0;
            $nilai += ($hasil->absen / $max['absen']) * $bobot['absen'];
            $nilai += ($hasil->prestasi / $max['prestasi']) * $bobot['prestasi'];
            $nilai += ($hasil->kinerja / $max['kinerja']) * $bobot['kinerja'];

            $hasil->nilai_saw = round($nilai, 3);

            if ($nilai < 0.4) {
                $hasil->kategori = "Kurang";
            } elseif ($nilai < 0.7) {
                $hasil->kategori = "Cukup";
            } else {
                $hasil->kategori = "Baik";
            }
        }

        return response()->json($hasils);
    }
    public function getData($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        return response()->json($penilaian);
    }

    public function update(Request $request, $id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->absen = $request->absen;
        $penilaian->prestasi = $request->prestasi;
        $penilaian->kinerja = $request->kinerja;
        $penilaian->save();

        return redirect()->back()->with('success', 'Penilaian berhasil diperbarui');
    }
}
