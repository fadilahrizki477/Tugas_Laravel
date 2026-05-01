<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;

class MatakuliahController extends Controller
{
    public function index()
    {
        $dataMatakuliah = Matakuliah::orderBy('kode_matakuliah', 'asc')->get();
        return view('matakuliah.index', compact('dataMatakuliah'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kode_matakuliah' => 'required|max:8|unique:matakuliah,kode_matakuliah',
                'nama_matakuliah' => 'required|min:3|max:50',
                'sks'             => 'required|numeric|min:1|max:6',
            ],
            [
                'kode_matakuliah.required' => 'Kode matakuliah tidak boleh dikosongkan',
                'kode_matakuliah.unique'   => 'Kode matakuliah sudah terdaftar',
                'nama_matakuliah.required' => 'Nama matakuliah tidak boleh dikosongkan',
                'nama_matakuliah.min'      => 'Nama matakuliah terlalu pendek, minimal 3 karakter',
                'sks.required'             => 'SKS tidak boleh dikosongkan',
                'sks.numeric'              => 'SKS harus berupa angka',
            ]
        );

        Matakuliah::create($validated);
        return redirect()->route('matakuliah')->with('success', 'Data matakuliah berhasil ditambahkan');
    }

    public function show(string $kode)
    {
        $detailMatakuliah = Matakuliah::findOrFail($kode);
        return view('matakuliah.detail', compact('detailMatakuliah'));
    }

    public function edit(string $kode)
    {
        $detailMatakuliah = Matakuliah::findOrFail($kode);
        return view('matakuliah.create', compact('detailMatakuliah'));
    }

    public function update(Request $request, string $kode)
    {
        $validated = $request->validate(
            [
                'nama_matakuliah' => 'required|min:3|max:50',
                'sks'             => 'required|numeric|min:1|max:6',
            ],
            [
                'nama_matakuliah.required' => 'Nama matakuliah tidak boleh dikosongkan',
                'nama_matakuliah.min'      => 'Nama matakuliah terlalu pendek, minimal 3 karakter',
                'sks.required'             => 'SKS tidak boleh dikosongkan',
                'sks.numeric'              => 'SKS harus berupa angka',
            ]
        );

        Matakuliah::where('kode_matakuliah', $kode)->update($validated);
        return redirect()->route('matakuliah.index')->with('success', 'Data matakuliah berhasil diubah');
    }

    public function destroy(string $kode)
    {
        //
    }
}