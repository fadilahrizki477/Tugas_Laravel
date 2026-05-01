@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2>Halaman Jadwal</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-header">Daftar Jadwal</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Matakuliah</th>
                        <th>Dosen</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataJadwal as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->matakuliah->nama_matakuliah ?? '-' }}</td>
                        <td>{{ $item->dosen->nama ?? '-' }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm">Hapus</button>
                            <a href="{{ route('jadwal.edit', ['id' => $item->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('jadwal.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection