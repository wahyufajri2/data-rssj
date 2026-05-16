<?php

namespace App\Http\Controllers\Patient;

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

        // Mengirimkan data user langsung ke view
        // Sesuaikan nama view ('pages.patient.profile') dengan lokasi file blade Anda
        return view('pages.patient.profil', [
            'title' => 'Profil Saya',
            'user'  => $user,
        ]);
    }

    /**
     * Menyimpan pembaruan data profil pasien
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            // Memastikan Nomor HP diisi dan tidak duplikat dengan akun lain
            'no_hp' => ['required', 'string', 'max:20', 'unique:users,no_hp,' . $user->id],
            // Email dibuat opsional (nullable) untuk pasien, tapi jika diisi tidak boleh duplikat
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.unique'   => 'Nomor HP ini sudah terdaftar pada akun lain.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name'  => $validatedData['name'],
            'no_hp' => $validatedData['no_hp'],
            'email' => $validatedData['email'],
        ]);

        // Menggunakan back() agar kembali ke halaman yang sama persis
        return back()->with('status', 'Data profil Anda berhasil diperbarui.');
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

        return back()->with('status', 'Kata sandi berhasil diperbarui dengan aman.');
    }
}
