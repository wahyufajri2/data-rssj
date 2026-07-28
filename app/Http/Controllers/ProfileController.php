<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        $rules['current_password'] = ['nullable', 'required_with:password', 'current_password'];
        $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];

        $validated = $request->validate($rules);

        $user->name = $validated['name'];

        $emailChanged = false;
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
            $emailChanged = true;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('dashboard', ['role' => $user->role === 'admin_ranting' ? 'admin-ranting' : $user->role])
                             ->with('success', 'Profil diperbarui. Silakan periksa email Anda untuk memverifikasi alamat email baru.');
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
