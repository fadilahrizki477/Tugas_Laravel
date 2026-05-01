<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function index()
    {
        $dataDosen = Dosen::orderBy('nidn', 'asc')->get();
        return view('dosen.index', compact('dataDosen'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nidn' => 'required|max:10|unique:dosen,nidn',
                'nama' => 'required|min:3|max:50',
            ],
            [
                'nidn.required' => 'NIDN tidak boleh dikosongkan',
                'nidn.unique'   => 'NIDN sudah terdaftar',
                'nama.required' => 'Nama tidak boleh dikosongkan',
                'nama.min'      => 'Nama terlalu pendek, minimal 3 karakter',
            ]
        );

        Dosen::create($validated);
        return redirect()->route('dosen')->with('success', 'Data dosen berhasil ditambahkan');
    }

    public function show(string $nidn)
    {
        $detailDosen = Dosen::findOrFail($nidn);
        return view('dosen.detail', compact('detailDosen'));
    }

    public function edit(string $nidn)
    {
        $detailDosen = Dosen::findOrFail($nidn);
        return view('dosen.create', compact('detailDosen'));
    }

    public function update(Request $request, string $nidn)
    {
        $validated = $request->validate(
            [
                'nama' => 'required|min:3|max:50',
            ],
            [
                'nama.required' => 'Nama tidak boleh dikosongkan',
                'nama.min'      => 'Nama terlalu pendek, minimal 3 karakter',
            ]
        );

        Dosen::where('nidn', $nidn)->update($validated);
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diubah');
    }

    public function destroy(string $nidn)
    {
        //
    }
}
