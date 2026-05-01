@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>{{ isset($detailMahasiswa) ? 'Edit' : 'Tambah' }} Mahasiswa</h1>
    <div class="card">
        <div class="card-header">{{ isset($detailMahasiswa) ? 'Edit' : 'Tambah' }} Mahasiswa</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailMahasiswa) ? route('mahasiswa.update', ['npm' => $detailMahasiswa->npm]) : route('mahasiswa.store') }}">
                @csrf
                @if(isset($detailMahasiswa))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">NPM</label>
                    <input type="text" class="form-control" name="npm"
                        value="{{ old('npm', $detailMahasiswa->npm ?? '') }}"
                        maxlength="10"
                        {{ isset($detailMahasiswa) ? '' : '' }}>
                    @error('npm')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Dosen Wali</label>
                    <select name="nidn" class="form-select">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosen as $d)
                            <option value="{{ $d->nidn }}"
                                {{ old('nidn', $detailMahasiswa->nidn ?? '') == $d->nidn ? 'selected' : '' }}>
                                {{ $d->nama }} ({{ $d->nidn }})
                            </option>
                        @endforeach
                    </select>
                    @error('nidn')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama"
                        value="{{ old('nama', $detailMahasiswa->nama ?? '') }}"
                        maxlength="50">
                    @error('nama')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection