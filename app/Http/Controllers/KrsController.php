<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    public function index()
    {
        $krs = Krs::with(['mahasiswa', 'matakuliah'])->get();
        return view('krs.index', compact('krs'));
    }

    public function create()
    {
        $mahasiswa  = Mahasiswa::all();
        $matakuliah = Matakuliah::all();
        return view('krs.create', compact('mahasiswa', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm'             => 'required|exists:mahasiswa,npm',
            'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
        ]);

        Krs::create($request->all());

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil ditambahkan!');
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
