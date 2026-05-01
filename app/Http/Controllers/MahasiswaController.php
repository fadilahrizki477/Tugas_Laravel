<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class MahasiswaController extends Controller
{
    public function index()
    {
        $dataMahasiswa = Mahasiswa::with('dosen')->orderBy('npm', 'asc')->get();
        return view('mahasiswa.index', compact('dataMahasiswa'));
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
        return redirect()->route('mahasiswa')->with('success', 'Data mahasiswa berhasil ditambahkan');
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
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diubah');
    }

    public function destroy(string $npm)
    {
        //
    }
}