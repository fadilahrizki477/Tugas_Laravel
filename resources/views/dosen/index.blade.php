@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1>Halaman Dosen</h1>
    </div>
</div>

<div class="container-fluid">

    @if(session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Dosen</h3>
        </div>
        <div class="card-body">
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('dosen.create') }}" class="btn btn-primary">Tambah Data</a>

                <form class="d-flex" method="GET" action="{{ route('dosen.index') }}">
                    <input class="form-control mr-2" type="search" name="search" placeholder="Cari Dosen" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div>
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
                    @forelse($dataDosen as $index => $item)
                    <tr>
                        <td class="text-center">{{ $dataDosen->firstItem() + $index }}</td>
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
                    @empty
                    <tr>
                        <td colspan="4">
                            <span class="text-danger">data yang anda cari tidak ada</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $dataDosen->links() }}
        </div>
    </div>
</div>
@endsection
