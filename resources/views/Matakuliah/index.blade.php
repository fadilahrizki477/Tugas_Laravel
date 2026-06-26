@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h2>Halaman Matakuliah</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">Tambah Data</a>

                <form class="d-flex" method="GET" action="{{ route('matakuliah.index') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari Matakuliah" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
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
                    @forelse($dataMatakuliah as $index => $item)
                    <tr>
                        <td class="text-center">{{ $dataMatakuliah->firstItem() + $index }}</td>
                        <td>{{ $item->kode_matakuliah }}</td>
                        <td>{{ $item->nama_matakuliah }}</td>
                        <td>{{ $item->sks }}</td>
                        <td>
                            <form action="{{ route('matakuliah.delete', ['kode' => $item->kode_matakuliah]) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ route('matakuliah.edit', ['kode' => $item->kode_matakuliah]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('matakuliah.detail', ['kode' => $item->kode_matakuliah]) }}" class="btn btn-info btn-sm">Detail</a>
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
            {{ $dataMatakuliah->links() }}
        </div>
    </div>
</div>
@endsection