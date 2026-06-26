@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h2>Halaman Mahasiswa</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">Tambah Data</a>

                <form class="d-flex" method="GET" action="{{ route('mahasiswa.index') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari Mahasiswa" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
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
                    @forelse($dataMahasiswa as $index => $item)
                    <tr>
                        <td class="text-center">{{ $dataMahasiswa->firstItem() + $index }}</td>
                        <td>{{ $item->npm }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->dosen->nama ?? '-' }}</td>
                        <td>
                            <form action="{{ route('mahasiswa.delete', ['npm' => $item->npm]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ route('mahasiswa.edit', ['npm' => $item->npm]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('mahasiswa.detail', ['npm' => $item->npm]) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('mahasiswa.reset-password', ['npm' => $item->npm]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Reset password mahasiswa ini ke default (password)?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-secondary btn-sm">Reset Password</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <span class="text-danger">data yang anda cari tidak ada</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $dataMahasiswa->links() }}
        </div>
    </div>
</div>
@endsection