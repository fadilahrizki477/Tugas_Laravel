<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DeveloperController extends Controller
{
    public function resetAdminPassword(Request $request)
    {
        $secretKey = env('ADMIN_RESET_KEY');

        if (!$secretKey || $request->query('key') !== $secretKey) {
            abort(404);
        }

        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return 'Tidak ada akun admin yang ditemukan.';
        }

        $admin->update(['password' => Hash::make('password')]);

        return 'Password admin (' . $admin->email . ') berhasil direset ke: password';
    }
}
