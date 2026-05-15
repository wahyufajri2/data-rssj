<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PenggunaService
{
    /**
     * Menyiapkan aturan validasi (Rules)
     */
    public function getValidationRules($id = null)
    {
        return [
            'name'      => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'fullname'  => 'required|string|max:255',
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password'  => $id ? 'nullable|string|min:6' : 'required|string|min:6',
            'no_hp'     => 'nullable|string|max:20',
            'peran_id'  => 'required|exists:peran,id', // Sesuaikan dengan nama tabel
            'prodi_id'  => 'nullable',
            'active'    => 'nullable'
        ];
    }

    /**
     * Menyiapkan pesan error custom (Messages)
     */
    public function getValidationMessages()
    {
        return [
            'name.required'     => 'Username wajib diisi.',
            'name.unique'       => 'Username sudah digunakan.',
            'fullname.required' => 'Nama Lengkap wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'peran_id.required' => 'Peran wajib dipilih.',
            'peran_id.exists'   => 'Peran tidak valid.',
        ];
    }

    /**
     * Menyiapkan data untuk disimpan (Hashing & Casting)
     */
    public function prepareUserData(array $data)
    {
        // Handle Password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle Active Status
        $data['active'] = isset($data['active']) ? (int) $data['active'] : 0;

        return $data;
    }

    /**
     * Create User Logic
     */
    public function createUser(array $data)
    {
        try {
            return User::create($this->prepareUserData($data));
        } catch (\Exception $e) {
            Log::error("Error create user: " . $e->getMessage());
            throw new \Exception("Gagal menyimpan data pengguna.");
        }
    }

    /**
     * Update User Logic
     */
    public function updateUser($id, array $data)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($this->prepareUserData($data));
            return $user;
        } catch (\Exception $e) {
            Log::error("Error update user ID {$id}: " . $e->getMessage());
            throw new \Exception("Gagal memperbarui data pengguna.");
        }
    }

    /**
     * Delete User Logic
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Error delete user ID {$id}: " . $e->getMessage());
            throw new \Exception("Gagal menghapus data pengguna.");
        }
    }
}
