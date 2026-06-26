@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>Detail Matakuliah</h1>
    <div class="card card-outline card-primary">
        <div class="card-header">Detail Data Matakuliah</div>
        <div class="card-body">
            <p>Kode Matakuliah: {{ $detailMatakuliah->kode_matakuliah }}</p>
            <p>Nama Matakuliah: {{ $detailMatakuliah->nama_matakuliah }}</p>
            <p>SKS: {{ $detailMatakuliah->sks }}</p>
            <p>Dibuat Pada: {{ $detailMatakuliah->created_at }}</p>
            <p>Diubah Pada: {{ $detailMatakuliah->updated_at }}</p>
            <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection