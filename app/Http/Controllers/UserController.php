<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Hanya Superadmin yang bisa mengakses ini (diatur di web.php middleware role:superadmin)
        $users = User::with('ranting')->where('role', 'admin_ranting')->paginate(20);
        return view('superadmin.users.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('superadmin.users.index')->with('success', "Akun {$user->name} berhasil {$status}.");
    }
}
