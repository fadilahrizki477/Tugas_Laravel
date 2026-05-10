@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2>Halaman Jadwal</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

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
                            <form action="{{ route('jadwal.delete', ['id' => $item->id]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
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