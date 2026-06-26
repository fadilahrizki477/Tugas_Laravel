<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalDosen      = Dosen::count();
            $totalMahasiswa  = Mahasiswa::count();
            $totalMatakuliah = Matakuliah::count();
            $totalJadwal     = Jadwal::count();
            $totalKrs        = Krs::count();

            return view('dashboard', compact(
                'totalDosen',
                'totalMahasiswa',
                'totalMatakuliah',
                'totalJadwal',
                'totalKrs'
            ));
        }

        // Mahasiswa: statistik milik sendiri
        $krsSaya = Krs::where('npm', $user->npm)->get(['kode_matakuliah', 'kelas']);

        $totalKrsSaya = $krsSaya->count();

        $totalJadwal = Jadwal::where(function ($q) use ($krsSaya) {
            foreach ($krsSaya as $krs) {
                $q->orWhere(function ($qq) use ($krs) {
                    $qq->where('kode_matakuliah', $krs->kode_matakuliah)
                        ->where('kelas', $krs->kelas);
                });
            }
        })
            ->when($krsSaya->isEmpty(), fn($q) => $q->whereRaw('1 = 0'))
            ->count();

        $krsTerbaru = Krs::with('matakuliah')
            ->where('npm', $user->npm)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('totalKrsSaya', 'totalJadwal', 'krsTerbaru'));
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate(
            [
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'password.required'  => 'Password baru tidak boleh dikosongkan',
                'password.confirmed' => 'Konfirmasi password tidak sama',
            ]
        );

        // retrieve the Eloquent user model to ensure ->save() is available
        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah');
    }
}
