@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h2>Halaman KRS</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('krs.create') }}" class="btn btn-primary">Tambah Data</a>
                    <a href="{{ route('krs.export-pdf') }}" target="_blank" class="btn btn-outline-dark">Export PDF</a>
                    <a href="{{ route('krs.export-excel') }}" class="btn btn-outline-success">Export Excel</a>
                </div>

                <form class="d-flex" method="GET" action="{{ route('krs.index') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari KRS" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div>
            <div class="card-header">Daftar KRS</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Matakuliah</th>
                        <th>Kelas</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKrs as $index => $item)
                    <tr>
                        <td class="text-center">{{ $dataKrs->firstItem() + $index }}</td>
                        <td>{{ $item->npm }}</td>
                        <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $item->matakuliah->nama_matakuliah ?? '-' }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td>
                            <form action="{{ route('krs.delete', ['id' => $item->id]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ route('krs.edit', ['id' => $item->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('krs.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <span class="text-danger">data yang anda cari tidak ada</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $dataKrs->links() }}
        </div>
    </div>
</div>
@endsection