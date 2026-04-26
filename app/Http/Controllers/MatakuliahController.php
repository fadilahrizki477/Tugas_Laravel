<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliah'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|max:8|unique:matakuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|max:50',
            'sks'             => 'required|integer|min:1|max:6',
        ]);

        Matakuliah::create($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Data matakuliah berhasil ditambahkan!');
    }

    public function edit($kode)
    {
        
    }

    public function update(Request $request, $kode)
    {
        
    }

    public function destroy($kode)
    {
        
    }
}
