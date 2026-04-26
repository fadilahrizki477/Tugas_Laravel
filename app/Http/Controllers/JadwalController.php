<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['matakuliah', 'dosen'])->get();
        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $matakuliah = Matakuliah::all();
        $dosen      = Dosen::all();
        return view('jadwal.create', compact('matakuliah', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
            'nidn'            => 'required|exists:dosen,nidn',
            'kelas'           => 'required|max:1',
            'hari'            => 'required|max:10',
            'jam'             => 'required',
        ]);

        Jadwal::create([
            'kode_matakuliah' => $request->kode_matakuliah,
            'nidn'            => $request->nidn,
            'kelas'           => $request->kelas,
            'hari'            => $request->hari,
            'jam'             => '2000-01-01 ' . $request->jam . ':00',
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal berhasil ditambahkan!');
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
