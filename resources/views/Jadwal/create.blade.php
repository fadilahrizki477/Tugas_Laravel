@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>{{ isset($detailJadwal) ? 'Edit' : 'Tambah' }} Jadwal</h1>
    <div class="card">
        <div class="card-header">{{ isset($detailJadwal) ? 'Edit' : 'Tambah' }} Jadwal</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailJadwal) ? route('jadwal.update', ['id' => $detailJadwal->id]) : route('jadwal.store') }}">
                @csrf
                @if(isset($detailJadwal))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Matakuliah</label>
                    <select name="kode_matakuliah" class="form-select">
                        <option value="">-- Pilih Matakuliah --</option>
                        @foreach($matakuliah as $mk)
                            <option value="{{ $mk->kode_matakuliah }}"
                                {{ old('kode_matakuliah', $detailJadwal->kode_matakuliah ?? '') == $mk->kode_matakuliah ? 'selected' : '' }}>
                                {{ $mk->nama_matakuliah }} ({{ $mk->kode_matakuliah }})
                            </option>
                        @endforeach
                    </select>
                    @error('kode_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Dosen</label>
                    <select name="nidn" class="form-select">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosen as $d)
                            <option value="{{ $d->nidn }}"
                                {{ old('nidn', $detailJadwal->nidn ?? '') == $d->nidn ? 'selected' : '' }}>
                                {{ $d->nama }} ({{ $d->nidn }})
                            </option>
                        @endforeach
                    </select>
                    @error('nidn')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-select">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach(['A','B','C','D','E'] as $k)
                            <option value="{{ $k }}"
                                {{ old('kelas', $detailJadwal->kelas ?? '') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kelas')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-select">
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                            <option value="{{ $h }}"
                                {{ old('hari', $detailJadwal->hari ?? '') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jam</label>
                    <input type="time" class="form-control" name="jam"
                        value="{{ old('jam', isset($detailJadwal) ? \Carbon\Carbon::parse($detailJadwal->jam)->format('H:i') : '') }}">
                    @error('jam')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection