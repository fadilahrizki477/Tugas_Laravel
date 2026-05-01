@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>Detail Mahasiswa</h1>
    <div class="card">
        <div class="card-header">Detail Data Mahasiswa</div>
        <div class="card-body">
            <p>NPM: {{ $detailMahasiswa->npm }}</p>
            <p>Nama: {{ $detailMahasiswa->nama }}</p>
            <p>Dosen Wali: {{ $detailMahasiswa->dosen->nama ?? '-' }} ({{ $detailMahasiswa->nidn }})</p>
            <p>Dibuat Pada: {{ $detailMahasiswa->created_at }}</p>
            <p>Diubah Pada: {{ $detailMahasiswa->updated_at }}</p>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection