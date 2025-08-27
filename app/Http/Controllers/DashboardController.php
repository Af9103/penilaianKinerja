<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Penilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Ambil semua penilaian tahun ini
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

        $kategoriList = [];

        foreach ($hasils as $hasil) {
            // Hitung nilai SAW
            $nilai = ($hasil->absen / $max['absen']) * $bobot['absen']
                + ($hasil->prestasi / $max['prestasi']) * $bobot['prestasi']
                + ($hasil->kinerja / $max['kinerja']) * $bobot['kinerja'];

            // Tentukan kategori
            if ($nilai < 0.4) {
                $kategori = "Kurang";
            } elseif ($nilai < 0.7) {
                $kategori = "Cukup";
            } else {
                $kategori = "Baik";
            }

            $kategoriList[] = $kategori;
        }

        // Tentukan kategori rata-rata
        if (count($kategoriList) === 0) {
            $rataRataKategori = "-"; // jika tidak ada data
        } elseif (count(array_unique($kategoriList)) === 1) {
            // Semua kategori sama
            $rataRataKategori = $kategoriList[0];
        } else {
            // Ambil kategori terbanyak
            $counts = array_count_values($kategoriList);
            arsort($counts);
            $rataRataKategori = key($counts);
        }

        $kategoriCount = [
            'Baik' => 0,
            'Cukup' => 0,
            'Kurang' => 0,
        ];

        foreach ($hasils as $hasil) {
            $nilai = ($hasil->absen / $max['absen']) * $bobot['absen']
                + ($hasil->prestasi / $max['prestasi']) * $bobot['prestasi']
                + ($hasil->kinerja / $max['kinerja']) * $bobot['kinerja'];

            if ($nilai < 0.4) {
                $kategori = "Kurang";
            } elseif ($nilai < 0.7) {
                $kategori = "Cukup";
            } else {
                $kategori = "Baik";
            }

            $kategoriCount[$kategori]++;
        }

        $nilaiUser = Penilaian::where('user_id', auth()->id())
            ->where('tahun', $currentYear)
            ->latest('created_at')
            ->first();

        $kategoriUser = null;
        $nilaiSAW = null;

        if ($nilaiUser) {
            // Hitung nilai SAW
            $nilaiSAW = ($nilaiUser->absen / $max['absen']) * $bobot['absen']
                + ($nilaiUser->prestasi / $max['prestasi']) * $bobot['prestasi']
                + ($nilaiUser->kinerja / $max['kinerja']) * $bobot['kinerja'];

            // Tentukan kategori
            if ($nilaiSAW < 0.4) {
                $kategoriUser = "Kurang";
            } elseif ($nilaiSAW < 0.7) {
                $kategoriUser = "Cukup";
            } else {
                $kategoriUser = "Baik";
            }
        }

        $kategoriClass = [
            'Baik' => 'text-success',
            'Cukup' => 'text-warning',
            'Kurang' => 'text-danger',
        ];

        return view('dashboard.index', [
            'tittle' => 'Dashboard | SIPEKA',
            'currentMonthYear' => Carbon::now()->isoFormat('MMMM YYYY'),
            'totalPegawai' => User::count(),
            'totalLaporan' => $hasils->count(),
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'rataRataKategori' => $rataRataKategori,
            'kategoriCount' => $kategoriCount, // kirim ke view
            'nilaiUser' => $nilaiUser,
            'kategoriUser' => $kategoriUser,
            'nilaiSAW' => $nilaiSAW,
            'kategoriClass' => $kategoriClass[$kategoriUser] ?? '',
        ]);
    }

}
