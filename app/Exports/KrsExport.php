<?php

namespace App\Exports;

use App\Models\Krs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KrsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $npm;

    /**
     * @param string|null $npm  Kalau diisi, hanya export KRS milik NPM tersebut.
     */
    public function __construct($npm = null)
    {
        $this->npm = $npm;
    }

    public function collection()
    {
        $query = Krs::with(['mahasiswa', 'matakuliah'])->orderBy('id');

        if ($this->npm) {
            $query->where('npm', $this->npm);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['No', 'NPM', 'Nama Mahasiswa', 'Kode Matakuliah', 'Nama Matakuliah', 'Kelas'];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->npm,
            $row->mahasiswa->nama ?? '-',
            $row->kode_matakuliah,
            $row->matakuliah->nama_matakuliah ?? '-',
            $row->kelas ?? '-',
        ];
    }
}
