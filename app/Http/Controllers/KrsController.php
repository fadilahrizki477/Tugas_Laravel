<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class KrsController extends Controller
{
    public function index()
    {
        $dataKrs = Krs::with(['mahasiswa', 'matakuliah'])->orderBy('id', 'asc')->get();
        return view('krs.index', compact('dataKrs'));
    }

    public function create()
    {
        $mahasiswa  = Mahasiswa::all();
        $matakuliah = Matakuliah::all();
        return view('krs.create', compact('mahasiswa', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'npm'             => 'required|exists:mahasiswa,npm',
                'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
            ],
            [
                'npm.required'             => 'Mahasiswa harus dipilih',
                'kode_matakuliah.required' => 'Matakuliah harus dipilih',
            ]
        );

        Krs::create($validated);
        return redirect()->route('krs')->with('success', 'Data KRS berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $detailKrs = Krs::with(['mahasiswa', 'matakuliah'])->findOrFail($id);
        return view('krs.detail', compact('detailKrs'));
    }

    public function edit(string $id)
    {
        $detailKrs  = Krs::findOrFail($id);
        $mahasiswa  = Mahasiswa::all();
        $matakuliah = Matakuliah::all();
        return view('krs.create', compact('detailKrs', 'mahasiswa', 'matakuliah'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'npm'             => 'required|exists:mahasiswa,npm',
                'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
            ],
            [
                'npm.required'             => 'Mahasiswa harus dipilih',
                'kode_matakuliah.required' => 'Matakuliah harus dipilih',
            ]
        );

        Krs::where('id', $id)->update($validated);
        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil diubah');
    }

    public function destroy(string $id)
    {
        //
    }
}