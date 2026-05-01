<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use App\Models\Dosen;

class JadwalController extends Controller
{
    public function index()
    {
        $dataJadwal = Jadwal::with(['matakuliah', 'dosen'])->orderBy('id', 'asc')->get();
        return view('jadwal.index', compact('dataJadwal'));
    }

    public function create()
    {
        $matakuliah = Matakuliah::all();
        $dosen      = Dosen::all();
        return view('jadwal.create', compact('matakuliah', 'dosen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
                'nidn'            => 'required|exists:dosen,nidn',
                'kelas'           => 'required|max:1',
                'hari'            => 'required|max:10',
                'jam'             => 'required',
            ],
            [
                'kode_matakuliah.required' => 'Matakuliah harus dipilih',
                'nidn.required'            => 'Dosen harus dipilih',
                'kelas.required'           => 'Kelas tidak boleh dikosongkan',
                'hari.required'            => 'Hari harus dipilih',
                'jam.required'             => 'Jam tidak boleh dikosongkan',
            ]
        );

        Jadwal::create([
            'kode_matakuliah' => $validated['kode_matakuliah'],
            'nidn'            => $validated['nidn'],
            'kelas'           => $validated['kelas'],
            'hari'            => $validated['hari'],
            'jam'             => '2000-01-01 ' . $validated['jam'] . ':00',
        ]);

        return redirect()->route('jadwal')->with('success', 'Data jadwal berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $detailJadwal = Jadwal::with(['matakuliah', 'dosen'])->findOrFail($id);
        return view('jadwal.detail', compact('detailJadwal'));
    }

    public function edit(string $id)
    {
        $detailJadwal = Jadwal::findOrFail($id);
        $matakuliah   = Matakuliah::all();
        $dosen        = Dosen::all();
        return view('jadwal.create', compact('detailJadwal', 'matakuliah', 'dosen'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'kode_matakuliah' => 'required|exists:matakuliah,kode_matakuliah',
                'nidn'            => 'required|exists:dosen,nidn',
                'kelas'           => 'required|max:1',
                'hari'            => 'required|max:10',
                'jam'             => 'required',
            ],
            [
                'kode_matakuliah.required' => 'Matakuliah harus dipilih',
                'nidn.required'            => 'Dosen harus dipilih',
                'kelas.required'           => 'Kelas tidak boleh dikosongkan',
                'hari.required'            => 'Hari harus dipilih',
                'jam.required'             => 'Jam tidak boleh dikosongkan',
            ]
        );

        Jadwal::where('id', $id)->update([
            'kode_matakuliah' => $validated['kode_matakuliah'],
            'nidn'            => $validated['nidn'],
            'kelas'           => $validated['kelas'],
            'hari'            => $validated['hari'],
            'jam'             => '2000-01-01 ' . $validated['jam'] . ':00',
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal berhasil diubah');
    }

    public function destroy(string $id)
    {
        //
    }
}
