<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Krs;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user   = Auth::user();

        $query = Jadwal::with(['matakuliah', 'dosen']);

        // Mahasiswa hanya melihat jadwal dari matakuliah+kelas yang sudah diambil di KRS
        if ($user && $user->npm) {
            $krsSaya = Krs::where('npm', $user->npm)->get(['kode_matakuliah', 'kelas']);

            $query->where(function ($q) use ($krsSaya) {
                foreach ($krsSaya as $krs) {
                    $q->orWhere(function ($qq) use ($krs) {
                        $qq->where('kode_matakuliah', $krs->kode_matakuliah)
                            ->where('kelas', $krs->kelas);
                    });
                }
            });

            // Kalau belum ada KRS sama sekali, pastikan hasil kosong (bukan semua data)
            if ($krsSaya->isEmpty()) {
                $query->whereRaw('1 = 0');
            }
        }

        $dataJadwal = $query
            ->when($search, function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('hari', 'like', "%{$search}%")
                       ->orWhere('kelas', 'like', "%{$search}%")
                       ->orWhereHas('matakuliah', function ($qqq) use ($search) {
                           $qqq->where('nama_matakuliah', 'like', "%{$search}%");
                       })
                       ->orWhereHas('dosen', function ($qqq) use ($search) {
                           $qqq->where('nama', 'like', "%{$search}%");
                       });
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->withQueryString();

        return view('jadwal.jadwal-index', compact('dataJadwal', 'search'));
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

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal berhasil ditambahkan');
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
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Data jadwal berhasil dihapus');
    }
}