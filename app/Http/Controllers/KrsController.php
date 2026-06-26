<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Exports\KrsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user   = Auth::user();

        $query = Krs::with(['mahasiswa', 'matakuliah']);

        // Mahasiswa hanya boleh melihat KRS miliknya sendiri
        if ($this->userIsMahasiswa($user)) {
            $query->where('npm', $user->npm);
        }

        $dataKrs = $query
            ->when($search, function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('npm', 'like', "%{$search}%")
                       ->orWhereHas('mahasiswa', function ($qqq) use ($search) {
                           $qqq->where('nama', 'like', "%{$search}%");
                       })
                       ->orWhereHas('matakuliah', function ($qqq) use ($search) {
                           $qqq->where('nama_matakuliah', 'like', "%{$search}%");
                       });
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->withQueryString();

        return view('krs.index', compact('dataKrs', 'search'));
    }

    /**
     * Ambil daftar kombinasi matakuliah+kelas yang punya jadwal.
     * Kalau $npm diisi, matakuliah yang sudah diambil mahasiswa tersebut dikecualikan.
     */
    private function getJadwalOptions($npm = null, $excludeId = null)
    {
        $jadwalList = Jadwal::with('matakuliah')->orderBy('kode_matakuliah')->orderBy('kelas')->get();

        if ($npm) {
            $sudahDiambil = Krs::where('npm', $npm)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->pluck('kode_matakuliah');

            $jadwalList = $jadwalList->reject(function ($jadwal) use ($sudahDiambil) {
                return $sudahDiambil->contains($jadwal->kode_matakuliah);
            });
        }

        return $jadwalList;
    }

    // Compatibility helpers: some projects define isMahasiswa()/isAdmin() on User,
    // others use a 'role' attribute. Use existing methods if present, otherwise
    // fall back to checking a 'role' property.
    private function userIsMahasiswa($user)
    {
        if (method_exists($user, 'isMahasiswa')) {
            return $user->isMahasiswa();
        }

        return isset($user->role) && $user->role === 'mahasiswa';
    }

    private function userIsAdmin($user)
    {
        if (method_exists($user, 'isAdmin')) {
            return $user->isAdmin();
        }

        return isset($user->role) && ($user->role === 'admin' || $user->role === 'administrator');
    }

    public function create()
    {
        $user = Auth::user();

        $mahasiswa     = $this->userIsAdmin($user) ? Mahasiswa::all() : collect();
        $jadwalOptions = $this->userIsAdmin($user) ? $this->getJadwalOptions() : $this->getJadwalOptions($user->npm);

        return view('krs.create', compact('mahasiswa', 'jadwalOptions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $npm  = $this->userIsAdmin($user) ? $request->npm : $user->npm;

        $rules = [
            'pilihan' => 'required',
        ];
        $messages = [
            'pilihan.required' => 'Matakuliah & kelas harus dipilih',
        ];

        if ($this->userIsAdmin($user)) {
            $rules['npm'] = 'required|exists:mahasiswa,npm';
            $messages['npm.required'] = 'Mahasiswa harus dipilih';
        }

        $request->validate($rules, $messages);

        // pilihan formatnya "kode_matakuliah|kelas"
        [$kodeMatakuliah, $kelas] = explode('|', $request->pilihan);

        // Validasi kombinasi matakuliah+kelas benar-benar punya jadwal
        $adaJadwal = Jadwal::where('kode_matakuliah', $kodeMatakuliah)->where('kelas', $kelas)->exists();
        if (!$adaJadwal) {
            return back()->withErrors(['pilihan' => 'Kombinasi matakuliah & kelas tidak memiliki jadwal'])->withInput();
        }

        // Cek belum pernah ambil matakuliah yang sama
        $sudahAmbil = Krs::where('npm', $npm)->where('kode_matakuliah', $kodeMatakuliah)->exists();
        if ($sudahAmbil) {
            return back()->withErrors(['pilihan' => 'Matakuliah ini sudah diambil oleh mahasiswa tersebut'])->withInput();
        }

        Krs::create([
            'npm'             => $npm,
            'kode_matakuliah' => $kodeMatakuliah,
            'kelas'           => $kelas,
        ]);

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $detailKrs = Krs::with(['mahasiswa', 'matakuliah'])->findOrFail($id);
        $user      = Auth::user();

        if ($this->userIsMahasiswa($user) && $detailKrs->npm !== $user->npm) {
            abort(403, 'Anda tidak memiliki akses ke data KRS ini.');
        }

        return view('krs.detail', compact('detailKrs'));
    }

    public function edit(string $id)
    {
        $detailKrs = Krs::findOrFail($id);
        $user      = Auth::user();

        if ($this->userIsMahasiswa($user) && $detailKrs->npm !== $user->npm) {
            abort(403, 'Anda tidak memiliki akses ke data KRS ini.');
        }

        $mahasiswa     = $this->userIsAdmin($user) ? Mahasiswa::all() : collect();
        $jadwalOptions = $this->userIsAdmin($user)
            ? $this->getJadwalOptions()
            : $this->getJadwalOptions($user->npm, $id);

        return view('krs.create', compact('detailKrs', 'mahasiswa', 'jadwalOptions'));
    }

    public function update(Request $request, string $id)
    {
        $detailKrs = Krs::findOrFail($id);
        $user      = Auth::user();

        if ($this->userIsMahasiswa($user) && $detailKrs->npm !== $user->npm) {
            abort(403, 'Anda tidak memiliki akses ke data KRS ini.');
        }

        $npm = $this->userIsAdmin($user) ? $request->npm : $user->npm;

        $rules = [
            'pilihan' => 'required',
        ];
        $messages = [
            'pilihan.required' => 'Matakuliah & kelas harus dipilih',
        ];

        if ($this->userIsAdmin($user)) {
            $rules['npm'] = 'required|exists:mahasiswa,npm';
            $messages['npm.required'] = 'Mahasiswa harus dipilih';
        }

        $request->validate($rules, $messages);

        [$kodeMatakuliah, $kelas] = explode('|', $request->pilihan);

        $adaJadwal = Jadwal::where('kode_matakuliah', $kodeMatakuliah)->where('kelas', $kelas)->exists();
        if (!$adaJadwal) {
            return back()->withErrors(['pilihan' => 'Kombinasi matakuliah & kelas tidak memiliki jadwal'])->withInput();
        }

        $sudahAmbil = Krs::where('npm', $npm)
            ->where('kode_matakuliah', $kodeMatakuliah)
            ->where('id', '!=', $id)
            ->exists();
        if ($sudahAmbil) {
            return back()->withErrors(['pilihan' => 'Matakuliah ini sudah diambil oleh mahasiswa tersebut'])->withInput();
        }

        $detailKrs->update([
            'npm'             => $npm,
            'kode_matakuliah' => $kodeMatakuliah,
            'kelas'           => $kelas,
        ]);

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil diubah');
    }

    public function destroy(string $id)
    {
        $krs  = Krs::findOrFail($id);
        $user = Auth::user();

        if ($this->userIsMahasiswa($user) && $krs->npm !== $user->npm) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data KRS ini.');
        }

        $krs->delete();
        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil dihapus');
    }

    public function exportPdf()
    {
        $user = Auth::user();

        $query = Krs::with(['mahasiswa', 'matakuliah'])->orderBy('id');

        $mahasiswaInfo = null;
        if ($this->userIsMahasiswa($user)) {
            $query->where('npm', $user->npm);
            $mahasiswaInfo = Mahasiswa::find($user->npm);
        }

        $dataKrs = $query->get();

        $pdf = Pdf::loadView('krs.pdf', compact('dataKrs', 'mahasiswaInfo'));

        return $pdf->stream('krs-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel()
    {
        $user = Auth::user();
        $npm  = $this->userIsMahasiswa($user) ? $user->npm : null;

        return Excel::download(new KrsExport($npm), 'krs-' . now()->format('Ymd-His') . '.xlsx');
    }
}