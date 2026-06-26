@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>{{ isset($detailKrs) ? 'Edit' : 'Tambah' }} KRS</h1>
    <div class="card card-outline card-primary">
        <div class="card-header">{{ isset($detailKrs) ? 'Edit' : 'Tambah' }} KRS</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailKrs) ? route('krs.update', ['id' => $detailKrs->id]) : route('krs.store') }}">
                @csrf
                @if(isset($detailKrs))
                    @method('PUT')
                @endif

                @if(auth()->user()->isAdmin())
                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <select name="npm" class="form-select">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswa as $m)
                            <option value="{{ $m->npm }}"
                                {{ old('npm', $detailKrs->npm ?? '') == $m->npm ? 'selected' : '' }}>
                                {{ $m->nama }} ({{ $m->npm }})
                            </option>
                        @endforeach
                    </select>
                    @error('npm')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }} ({{ auth()->user()->npm }})" disabled>
                    <small class="text-muted">KRS akan otomatis terdaftar atas nama Anda</small>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Matakuliah & Kelas</label>
                    <select name="pilihan" class="form-select">
                        <option value="">-- Pilih Matakuliah & Kelas --</option>
                        @foreach($jadwalOptions as $jadwal)
                            <option value="{{ $jadwal->kode_matakuliah }}|{{ $jadwal->kelas }}"
                                {{ old('pilihan', isset($detailKrs) ? $detailKrs->kode_matakuliah . '|' . $detailKrs->kelas : '') == $jadwal->kode_matakuliah . '|' . $jadwal->kelas ? 'selected' : '' }}>
                                {{ $jadwal->matakuliah->nama_matakuliah ?? $jadwal->kode_matakuliah }} - Kelas {{ $jadwal->kelas }} ({{ $jadwal->hari }})
                            </option>
                        @endforeach
                    </select>
                    @error('pilihan')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Hanya matakuliah yang memiliki jadwal aktif yang dapat dipilih</small>
                </div>

                <a href="{{ route('krs.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection