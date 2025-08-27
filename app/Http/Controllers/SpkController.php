<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Penilaian;
use App\Models\TmtPns;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function promosi(Request $request)
    {
        $currentYear = Carbon::now()->year;

        // Ambil semua hasil penilaian tahun berjalan + relasi user
        $hasils = Penilaian::with('user')
            ->where('tahun', $currentYear)
            ->get();

        // Bobot tiap kriteria
        $bobot = BobotKriteria::pluck('bobot', 'Kriteria')->toArray();

        // Skala maksimum tetap
        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        // Hitung nilai SAW + kategori
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

        // === FILTER ===
        $filtered = $hasils->filter(function ($hasil) use ($currentYear) {
            $user = $hasil->user;

            // Jika tmt_pns null -> hanya tahun berjalan & Baik
            if (is_null($user->tmt_pns)) {
                return $hasil->tahun == $currentYear && $hasil->kategori == "Baik";
            }

            // Jika selisih >= 4 tahun
            $selisih = $currentYear - Carbon::parse($user->tmt_pns)->year;
            if ($selisih >= 4) {
                // Ambil 4 penilaian terakhir user ini
                $last4 = Penilaian::where('user_id', $user->id)
                    ->orderBy('tahun', 'desc')
                    ->take(4)
                    ->get();

                // Hitung ulang kategori untuk setiap penilaian last4
                foreach ($last4 as $p) {
                    $nilai = 0;
                    $nilai += ($p->absen / 100) * (BobotKriteria::where('Kriteria', 'absen')->value('bobot'));
                    $nilai += ($p->prestasi / 10) * (BobotKriteria::where('Kriteria', 'prestasi')->value('bobot'));
                    $nilai += ($p->kinerja / 10) * (BobotKriteria::where('Kriteria', 'kinerja')->value('bobot'));

                    $p->nilai_saw = round($nilai, 3);

                    if ($nilai < 0.4) {
                        $p->kategori = "Kurang";
                    } elseif ($nilai < 0.7) {
                        $p->kategori = "Cukup";
                    } else {
                        $p->kategori = "Baik";
                    }
                }

                // Semua harus "Baik"
                return $last4->count() == 4 && $last4->every(fn($p) => $p->kategori == "Baik");
            }

            return false;
        });

        return view('spk.promosi', [
            'tittle' => 'Rekomendasi Promosi | SIPEKA',
            'hasils' => $filtered,
            'currentYear' => $currentYear,
        ]);
    }

    public function evaluasi(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Ambil data penilaian berdasarkan tahun + relasi user
        $hasils = Penilaian::with('user')
            ->where('tahun', $currentYear) // filter berdasarkan tahun
            ->get();

        // Bobot tiap kriteria
        $bobot = BobotKriteria::pluck('bobot', 'Kriteria')->toArray();

        // Skala maksimum tetap
        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        // Hitung nilai SAW dan kategori
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

        // Filter hanya yang kategori = "Cukup"
        $hasils = $hasils->where('kategori', 'Kurang');

        // Kirim data ke view
        return view('spk.evaluasi', [
            'tittle' => 'Evaluasi Karyawan | SIPEKA',
            'hasils' => $hasils,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }

    public function bobot()
    {
        $kriterias = BobotKriteria::all();

        // Pass the data to the view
        return view('spk.bobot', [
            'tittle' => 'Bobot Kriteria | SIPEKA',
            'kriterias' => $kriterias
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->bobot as $id => $nilai) {
            BobotKriteria::where('id', $id)->update(['bobot' => $nilai]);
        }

        return redirect()->back()->with('success', 'Bobot kriteria berhasil diupdate!');
    }

    public function Updatepromosi(Request $request, $id)
    {
        $request->validate([
            'gol' => 'required|string',
        ]);

        // update user
        $user = User::findOrFail($id);
        $user->gol = $request->gol;
        $user->tmt_pns = Carbon::now('Asia/Jakarta')->toDateString();
        $user->save();

        // insert ke tabel tmt_pns
        TmtPns::create([
            'user_id' => $id,
            'tmt' => Carbon::now('Asia/Jakarta')->toDateString(),
            'golongan' => $request->gol,
        ]);

        return redirect()->back()->with('success', 'Golongan & TMT PNS berhasil diperbarui dan riwayat tersimpan!');
    }

    public function laporanEvaluasi(Request $request)
    {
        $currentYear = Carbon::now()->year;

        // Ambil tahun dari request kalau ada
        $tahun = $request->input('tahun', $currentYear);

        // Ambil data penilaian berdasarkan tahun + relasi user
        $hasils = Penilaian::with('user')
            ->where('tahun', $tahun)
            ->get();

        // Bobot tiap kriteria
        $bobot = BobotKriteria::pluck('bobot', 'kriteria')->toArray();

        // Skala maksimum tetap
        $max = [
            'absen' => 100,
            'prestasi' => 10,
            'kinerja' => 10,
        ];

        // Hitung nilai SAW + kategori
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

        // ambil 5 terbaik dan 5 terburuk
        $top5 = $hasils->sortByDesc('nilai_saw')->take(5);
        $bottom5 = $hasils->sortBy('nilai_saw')->take(5);


        // Hitung ringkasan kategori
        $summary = [
            'total' => $hasils->count(),
            'baik' => $hasils->where('kategori', 'Baik')->count(),
            'cukup' => $hasils->where('kategori', 'Cukup')->count(),
            'kurang' => $hasils->where('kategori', 'Kurang')->count(),
        ];

        // Rata-rata kriteria
        $avg = [
            'absen' => round($hasils->avg('absen'), 2),
            'prestasi' => round($hasils->avg('prestasi'), 2),
            'kinerja' => round($hasils->avg('kinerja'), 2),
        ];

        // Narasi otomatis
        $narasi = "Pada tahun $tahun, hasil evaluasi menunjukkan bahwa mayoritas karyawan berada pada kategori "
            . ($summary['baik'] >= $summary['cukup'] && $summary['baik'] >= $summary['kurang'] ? "Baik" :
                ($summary['cukup'] >= $summary['kurang'] ? "Cukup" : "Kurang"))
            . ". Jumlah karyawan dievaluasi sebanyak {$summary['total']} orang, dengan rincian "
            . "{$summary['baik']} Baik, {$summary['cukup']} Cukup, dan {$summary['kurang']} Kurang.";

        return view('spk.lap-evaluasi', [
            'tittle' => 'Evaluasi Tahunan | SIPEKA',
            'tahun' => $tahun,
            'hasils' => $hasils,
            'summary' => $summary,
            'avg' => $avg,
            'narasi' => $narasi,
            'top5' => $top5,
            'bottom5' => $bottom5,
        ]);
    }
}
