<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // Constructor dihapus karena ProfileService sudah tidak digunakan

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Mengirimkan objek user langsung ke view
        // Sesuaikan nama view ini dengan lokasi file profil admin Anda (misal: 'admin.profile' atau 'pages.profile')
        return view('pages.admin.profile', [
            'title' => 'Profil Saya',
            'user'  => $user,
        ]);
    }

    /**
     * Menyimpan pembaruan data profil admin
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pengecekan role menggunakan string biasa karena sudah tidak pakai Enum.
        // Ganti 'role' dengan 'peran_id' jika Anda masih menggunakan nama kolom peran_id di database
        if (!in_array($user->role, ['admin', 'verifikator', 'super_admin'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengubah data profil di panel ini.');
        }

        $validatedData = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['nullable', 'string', 'max:20', 'unique:users,no_hp,' . $user->id], // Ditambahkan rule unique agar tidak bentrok
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
            'no_hp.unique'   => 'Nomor HP ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name'  => $validatedData['name'],
            'email' => $validatedData['email'],
            'no_hp' => $validatedData['no_hp'],
        ]);

        // Menggunakan back() agar lebih dinamis kembali ke halaman yang sama
        return back()->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Menyimpan pembaruan kata sandi
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required'         => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required'                 => 'Kata sandi baru wajib diisi.',
            'password.min'                      => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed'                => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
