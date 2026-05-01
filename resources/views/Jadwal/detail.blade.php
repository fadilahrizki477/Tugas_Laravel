@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>Detail Jadwal</h1>
    <div class="card">
        <div class="card-header">Detail Data Jadwal</div>
        <div class="card-body">
            <p>Matakuliah: {{ $detailJadwal->matakuliah->nama_matakuliah ?? '-' }}</p>
            <p>Kode Matakuliah: {{ $detailJadwal->kode_matakuliah }}</p>
            <p>Dosen: {{ $detailJadwal->dosen->nama ?? '-' }}</p>
            <p>Kelas: {{ $detailJadwal->kelas }}</p>
            <p>Hari: {{ $detailJadwal->hari }}</p>
            <p>Jam: {{ \Carbon\Carbon::parse($detailJadwal->jam)->format('H:i') }}</p>
            <p>Dibuat Pada: {{ $detailJadwal->created_at }}</p>
            <p>Diubah Pada: {{ $detailJadwal->updated_at }}</p>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection