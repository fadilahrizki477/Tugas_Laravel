@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>Detail Dosen</h1>
    <div class="card">
        <div class="card-header">Detail Data Dosen</div>
        <div class="card-body">
            <p>NIDN: {{ $detailDosen->nidn }}</p>
            <p>Nama: {{ $detailDosen->nama }}</p>
            <p>Dibuat Pada: {{ $detailDosen->created_at }}</p>
            <p>Diubah Pada: {{ $detailDosen->updated_at }}</p>
            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection