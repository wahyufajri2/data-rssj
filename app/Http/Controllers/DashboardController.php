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
    public function index()
    {
        $user = Auth::user();
        $isSuperadmin = $user->role === 'superadmin';
        $rantingId = $user->ranting_id;

        // --- STATISTIK UMUM ---
        $stats = [
            'total_admin' => $isSuperadmin ? User::where('role', 'admin_ranting')->count() : 0,
            'total_pendataan' => $isSuperadmin 
                ? PendataanKeluarga::count() 
                : PendataanKeluarga::where('ranting_id', $rantingId)->count(),
            'total_kuesioner' => $isSuperadmin 
                ? KuesionerMandiri::count() 
                : KuesionerMandiri::where('ranting_id', $rantingId)->count(),
        ];

        // --- LINE CHART (TREN 6 BULAN TERAKHIR) ---
        $months = [];
        $pendataanTrend = [];
        $kuesionerTrend = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $months[] = $date->translatedFormat('M Y'); // e.g. "Jul 2026"
            
            $pendataanQuery = PendataanKeluarga::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
            $kuesionerQuery = KuesionerMandiri::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            if (!$isSuperadmin) {
                $pendataanQuery->where('ranting_id', $rantingId);
                $kuesionerQuery->where('ranting_id', $rantingId);
            }

            $pendataanTrend[] = $pendataanQuery->count();
            $kuesionerTrend[] = $kuesionerQuery->count();
        }

        // --- PIE CHART (STATUS KESEHATAN) ---
        // Status kesehatan dari PendataanKeluarga
        $statusQuery = PendataanKeluarga::select('status_kesehatan', DB::raw('count(*) as total'))
            ->groupBy('status_kesehatan');
            
        if (!$isSuperadmin) {
            $statusQuery->where('ranting_id', $rantingId);
        }
        
        $statusData = $statusQuery->get();
        
        // Memastikan ketiga kategori selalu ada walau 0
        $pieLabels = ['Sehat Jiwa', 'ODGJ', 'ODK'];
        $pieSeries = [0, 0, 0];
        
        foreach ($statusData as $row) {
            $idx = array_search($row->status_kesehatan, $pieLabels);
            if ($idx !== false) {
                $pieSeries[$idx] = $row->total;
            }
        }

        // --- BAR CHART (PERBANDINGAN WILAYAH/DUSUN) ---
        $barLabels = [];
        $barSeries = [];
        
        if ($isSuperadmin) {
            // Superadmin: Top 5 Ranting by Pendataan
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
            // Admin Ranting: Jumlah Pendataan per Dusun
            $dusunData = PendataanKeluarga::where('ranting_id', $rantingId)
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
            'pieLabels', 'pieSeries',
            'barLabels', 'barSeries', 'barTitle'
        ));
    }
}
