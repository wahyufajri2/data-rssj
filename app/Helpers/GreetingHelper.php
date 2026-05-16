<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class GreetingHelper
{
    /**
     * Mengambil data sapaan, ikon, dan nama pengguna
     *
     * @return object
     */
    public static function getGreetingData(): object
    {
        // 1. Ambil waktu saat ini dengan format Jam:Menit (HH:MM)
        $waktu = now()->timezone('Asia/Jakarta')->format('H:i');

        // 2. Logika Penentuan Ucapan dan Ikon berdasarkan waktu
        if ($waktu >= '05:01' && $waktu <= '10:00') {
            $ucapan = 'Selamat Pagi !';
            $ikonMatahari = true;
        } elseif ($waktu >= '10:01' && $waktu <= '15:00') {
            $ucapan = 'Selamat Siang !';
            $ikonMatahari = true;
        } elseif ($waktu >= '15:01' && $waktu <= '18:00') {
            $ucapan = 'Selamat Sore !';
            $ikonMatahari = true;
        } else {
            // Jam 18:01 s/d 05:00
            $ucapan = 'Selamat Malam !';
            $ikonMatahari = false;
        }

        // 3. Ambil data nama (Cek Auth untuk mencegah error)
        $namaLengkap = 'Tamu';

        if (Auth::check()) {
            // Mengambil langsung dari kolom 'name' sesuai struktur tabel terbaru
            $namaLengkap = Auth::user()->name;
        }

        // Kembalikan data dalam bentuk Object agar mudah dipanggil di Blade
        return (object) [
            'ucapan'       => $ucapan,
            'ikonMatahari' => $ikonMatahari,
            'namaLengkap'  => $namaLengkap,
        ];
    }
}
