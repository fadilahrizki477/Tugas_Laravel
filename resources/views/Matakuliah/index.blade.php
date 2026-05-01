@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2>Halaman Matakuliah</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-header">Daftar Matakuliah</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kode</th>
                        <th>Nama Matakuliah</th>
                        <th>SKS</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataMatakuliah as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_matakuliah }}</td>
                        <td>{{ $item->nama_matakuliah }}</td>
                        <td>{{ $item->sks }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm">Hapus</button>
                            <a href="{{ route('matakuliah.edit', ['kode' => $item->kode_matakuliah]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('matakuliah.detail', ['kode' => $item->kode_matakuliah]) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection