@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>Detail KRS</h1>
    <div class="card card-outline card-primary">
        <div class="card-header">Detail Data KRS</div>
        <div class="card-body">
            <p>NPM: {{ $detailKrs->npm }}</p>
            <p>Nama Mahasiswa: {{ $detailKrs->mahasiswa->nama ?? '-' }}</p>
            <p>Matakuliah: {{ $detailKrs->matakuliah->nama_matakuliah ?? '-' }}</p>
            <p>Kode Matakuliah: {{ $detailKrs->kode_matakuliah }}</p>
            <p>Dibuat Pada: {{ $detailKrs->created_at }}</p>
            <p>Diubah Pada: {{ $detailKrs->updated_at }}</p>
            <a href="{{ route('krs.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection