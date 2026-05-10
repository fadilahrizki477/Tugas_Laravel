@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2>Halaman Dosen</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('dosen.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-header">Daftar Dosen</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NIDN</th>
                        <th>Nama</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataDosen as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nidn }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            <form action="{{ route('dosen.delete', ['nidn' => $item->nidn]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ route('dosen.edit', ['nidn' => $item->nidn]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('dosen.detail', ['nidn' => $item->nidn]) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection