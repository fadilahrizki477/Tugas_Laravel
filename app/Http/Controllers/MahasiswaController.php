<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dataMahasiswa = Mahasiswa::with('dosen')
            ->when($search, function ($query, $search) {
                $query->where('npm', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy('npm', 'asc')
            ->paginate(5)
            ->withQueryString();

        return view('mahasiswa.index', compact('dataMahasiswa', 'search'));
    }

    public function create()
    {
        $dosen = Dosen::all();
        return view('mahasiswa.create', compact('dosen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'npm'  => 'required|max:10|unique:mahasiswa,npm',
                'nidn' => 'required|exists:dosen,nidn',
                'nama' => 'required|min:3|max:50',
            ],
            [
                'npm.required'  => 'NPM tidak boleh dikosongkan',
                'npm.unique'    => 'NPM sudah terdaftar',
                'nidn.required' => 'Dosen wali harus dipilih',
                'nama.required' => 'Nama tidak boleh dikosongkan',
                'nama.min'      => 'Nama terlalu pendek, minimal 3 karakter',
            ]
        );

        Mahasiswa::create($validated);

        // Otomatis buat akun login untuk mahasiswa baru
        User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['npm'] . '@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'mahasiswa',
            'npm'      => $validated['npm'],
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan. Akun login otomatis dibuat (email: ' . $validated['npm'] . '@gmail.com, password: password)');
    }

    public function show(string $npm)
    {
        $detailMahasiswa = Mahasiswa::with('dosen')->findOrFail($npm);
        return view('mahasiswa.detail', compact('detailMahasiswa'));
    }

    public function edit(string $npm)
    {
        $detailMahasiswa = Mahasiswa::findOrFail($npm);
        $dosen           = Dosen::all();
        return view('mahasiswa.create', compact('detailMahasiswa', 'dosen'));
    }

    public function update(Request $request, string $npm)
    {
        $validated = $request->validate(
            [
                'nidn' => 'required|exists:dosen,nidn',
                'nama' => 'required|min:3|max:50',
            ],
            [
                'nidn.required' => 'Dosen wali harus dipilih',
                'nama.required' => 'Nama tidak boleh dikosongkan',
                'nama.min'      => 'Nama terlalu pendek, minimal 3 karakter',
            ]
        );

        Mahasiswa::where('npm', $npm)->update($validated);

        // Sinkronkan nama di akun login juga
        User::where('npm', $npm)->update(['name' => $validated['nama']]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diubah');
    }

    public function resetPassword(string $npm)
    {
        $user = User::where('npm', $npm)->first();

        if (!$user) {
            return redirect()->route('mahasiswa.index')->with('error', 'Akun login untuk mahasiswa ini tidak ditemukan.');
        }

        $user->update(['password' => Hash::make('password')]);

        return redirect()->route('mahasiswa.index')->with('success', 'Password mahasiswa berhasil direset ke default (password)');
    }

    public function destroy(string $npm)
    {
        $mahasiswa = Mahasiswa::findOrFail($npm);

        if ($mahasiswa->krs()->count() > 0) {
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak bisa dihapus karena masih memiliki data KRS terkait!');
        }

        // Hapus akun login terkait juga
        User::where('npm', $npm)->delete();

        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
