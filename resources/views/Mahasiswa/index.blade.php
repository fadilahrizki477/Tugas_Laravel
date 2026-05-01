@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2>Halaman Mahasiswa</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-header">Daftar Mahasiswa</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Dosen Wali</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataMahasiswa as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->npm }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->dosen->nama ?? '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm">Hapus</button>
                            <a href="{{ route('mahasiswa.edit', ['npm' => $item->npm]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('mahasiswa.detail', ['npm' => $item->npm]) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection