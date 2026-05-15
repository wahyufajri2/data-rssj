<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $user = Auth::user();

        $contactInfo = $this->profileService->getContactInfo($user);

        return view('pages.profile', [
            'title'     => 'Profil Saya',
            'infoLabel' => $contactInfo['label'],
            'infoValue' => $contactInfo['value'],
        ]);
    }

    /**
     * Menyimpan pembaruan data profil
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!in_array($user->peran_id, [Role::ADMIN->value, Role::VERIFIKATOR->value])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengubah data profil.');
        }

        $validatedData = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp'    => ['nullable', 'string', 'max:20'],
        ], [
            'fullname.required' => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'fullname' => $validatedData['fullname'],
            'email'    => $validatedData['email'],
            'no_hp'    => $validatedData['no_hp'],
        ]);

        return redirect()->route('profile')->with('success', 'Data profil berhasil diperbarui.');
    }

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
