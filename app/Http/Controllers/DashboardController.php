<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendataanKeluarga;
use App\Models\KuesionerMandiri;
use App\Models\Ranting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isSuperadmin = $user->role === 'superadmin';
        
        $requestRantingId = $request->input('ranting_id');
        if ($isSuperadmin && $requestRantingId && $requestRantingId !== 'all') {
            $filterRantingId = $requestRantingId;
        } elseif (!$isSuperadmin) {
            $filterRantingId = $user->ranting_id;
        } else {
            $filterRantingId = null;
        }

        $rantings = Ranting::all();

        // --- STATISTIK UMUM ---
        $adminQuery = User::where('role', 'admin_ranting');
        if ($filterRantingId) {
            $adminQuery->where('ranting_id', $filterRantingId);
        }

        $pendataanQuery = PendataanKeluarga::query();
        $kuesionerQuery = KuesionerMandiri::query();
        
        if ($filterRantingId) {
            $pendataanQuery->where('ranting_id', $filterRantingId);
            $kuesionerQuery->where('ranting_id', $filterRantingId);
        }

        $totalIndividuPendataan = $pendataanQuery->count();
        $totalKuesioner = $kuesionerQuery->count();
        
        // Clone for distinct keluarga
        $keluargaQueryBase = clone $pendataanQuery;
        $totalKeluarga = $keluargaQueryBase->distinct('no_kk')->count('no_kk');

        $stats = [
            'total_admin' => $isSuperadmin ? $adminQuery->count() : 0,
            'total_keluarga' => $totalKeluarga,
            'total_individu' => $totalIndividuPendataan + $totalKuesioner,
            'total_kuesioner' => $totalKuesioner,
            'individu_pendataan' => $totalIndividuPendataan,
        ];

        // --- PIE CHART & DETAIL STATUS (STATUS KESEHATAN) ---
        // Status kesehatan Individu
        $statusIndividuQuery = PendataanKeluarga::select('status_kesehatan', DB::raw('count(*) as total'))
            ->groupBy('status_kesehatan');
            
        if ($filterRantingId) {
            $statusIndividuQuery->where('ranting_id', $filterRantingId);
        }
        $statusIndividuData = $statusIndividuQuery->get();
        
        $pieLabels = ['Sehat Jiwa', 'ODK (Resiko)', 'ODGJ (Jiwa)'];
        $pieSeriesIndividu = [0, 0, 0];
        foreach ($statusIndividuData as $row) {
            if ($row->status_kesehatan == 'sehat') $pieSeriesIndividu[0] += $row->total;
            if ($row->status_kesehatan == 'resiko') $pieSeriesIndividu[1] += $row->total;
            if ($row->status_kesehatan == 'jiwa') $pieSeriesIndividu[2] += $row->total;
        }
        
        $stats['individu_sehat'] = $pieSeriesIndividu[0];
        $stats['individu_resiko'] = $pieSeriesIndividu[1];
        $stats['individu_jiwa'] = $pieSeriesIndividu[2];

        // Status kesehatan Keluarga (berdasarkan no_kk)
        $keluargaQuery = PendataanKeluarga::select('no_kk', 'status_kesehatan');
        if ($filterRantingId) {
            $keluargaQuery->where('ranting_id', $filterRantingId);
        }
        $keluargaData = $keluargaQuery->get();
        
        $keluargaStatus = [];
        foreach ($keluargaData as $row) {
            if (!isset($keluargaStatus[$row->no_kk])) {
                $keluargaStatus[$row->no_kk] = 'sehat';
            }
            if ($row->status_kesehatan == 'jiwa') {
                $keluargaStatus[$row->no_kk] = 'jiwa';
            } elseif ($row->status_kesehatan == 'resiko' && $keluargaStatus[$row->no_kk] != 'jiwa') {
                $keluargaStatus[$row->no_kk] = 'resiko';
            }
        }
        
        $pieSeriesKeluarga = [0, 0, 0];
        foreach ($keluargaStatus as $status) {
            if ($status == 'sehat') $pieSeriesKeluarga[0]++;
            if ($status == 'resiko') $pieSeriesKeluarga[1]++;
            if ($status == 'jiwa') $pieSeriesKeluarga[2]++;
        }
        
        $stats['keluarga_sehat'] = $pieSeriesKeluarga[0];
        $stats['keluarga_resiko'] = $pieSeriesKeluarga[1];
        $stats['keluarga_jiwa'] = $pieSeriesKeluarga[2];


        // --- LINE CHART (TREN 6 BULAN TERAKHIR) ---
        $months = [];
        $pendataanTrend = [];
        $kuesionerTrend = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $months[] = $date->translatedFormat('M Y'); // e.g. "Jul 2026"
            
            $pendataanQ = PendataanKeluarga::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
            $kuesionerQ = KuesionerMandiri::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            if ($filterRantingId) {
                $pendataanQ->where('ranting_id', $filterRantingId);
                $kuesionerQ->where('ranting_id', $filterRantingId);
            }

            $pendataanTrend[] = $pendataanQ->count();
            $kuesionerTrend[] = $kuesionerQ->count();
        }

        // --- BAR CHART (PERBANDINGAN WILAYAH/DUSUN) ---
        $barLabels = [];
        $barSeries = [];
        
        if (!$filterRantingId) {
            // Superadmin (Semua Ranting): Top 5 Ranting by Pendataan
            $rantingData = PendataanKeluarga::select('ranting_id', DB::raw('count(*) as total'))
                ->with('ranting')
                ->groupBy('ranting_id')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
                
            foreach ($rantingData as $row) {
                $barLabels[] = $row->ranting ? $row->ranting->nama_ranting : 'Unknown';
                $barSeries[] = $row->total;
            }
            $barTitle = 'Top 5 Ranting (Jumlah Pendataan)';
        } else {
            // Filtered Ranting: Jumlah Pendataan per Dusun
            $dusunData = PendataanKeluarga::where('ranting_id', $filterRantingId)
                ->select('alamat_dusun', DB::raw('count(*) as total'))
                ->groupBy('alamat_dusun')
                ->orderByDesc('total')
                ->limit(7)
                ->get();
                
            foreach ($dusunData as $row) {
                $barLabels[] = $row->alamat_dusun ?: 'Tanpa Dusun';
                $barSeries[] = $row->total;
            }
            $barTitle = 'Jumlah Pendataan per Dusun (Top 7)';
        }

        return view('dashboard', compact(
            'stats',
            'months', 'pendataanTrend', 'kuesionerTrend',
            'pieLabels', 'pieSeriesIndividu', 'pieSeriesKeluarga',
            'barLabels', 'barSeries', 'barTitle',
            'rantings', 'filterRantingId', 'isSuperadmin'
        ));
    }
}
