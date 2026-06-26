@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h2>{{ auth()->user()->isAdmin() ? 'Halaman Jadwal' : 'Jadwal Kuliah Saya' }}</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="mb-2 d-flex justify-content-between align-items-center">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Data</a>
                @else
                <span></span>
                @endif

                <form class="d-flex" method="GET" action="{{ route('jadwal.index') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari Jadwal" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div>
            <div class="card-header">{{ auth()->user()->isAdmin() ? 'Daftar Jadwal' : 'Jadwal Matakuliah yang Saya Ambil' }}</div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Matakuliah</th>
                        <th>Dosen</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        @if(auth()->user()->isAdmin())
                        <th width="25%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataJadwal as $index => $item)
                    <tr>
                        <td class="text-center">{{ $dataJadwal->firstItem() + $index }}</td>
                        <td>{{ $item->matakuliah->nama_matakuliah ?? '-' }}</td>
                        <td>{{ $item->dosen->nama ?? '-' }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                        @if(auth()->user()->isAdmin())
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
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">
                            @if(auth()->user()->isAdmin())
                            <span class="text-danger">data yang anda cari tidak ada</span>
                            @else
                            <span class="text-danger">
                                Anda belum mengambil KRS. Silakan
                                <a href="{{ route('krs.index') }}">ambil KRS</a> terlebih dahulu untuk melihat jadwal kuliah.
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $dataJadwal->links() }}
        </div>
    </div>
</div>
@endsection