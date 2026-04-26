@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header">Form Tambah Mahasiswa</div>
        <div class="card-body">

            <form method="POST" action="{{ route('mahasiswa.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NPM</label>
                    <input type="text" class="form-control" name="npm" value="{{ old('npm') }}" maxlength="10" placeholder="Masukkan NPM (10 digit)">
                    @error('npm')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Dosen Wali</label>
                    <select name="nidn" class="form-select">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosen as $d)
                        <option value="{{ $d->nidn }}" {{ old('nidn') == $d->nidn ? 'selected' : '' }}>
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
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" maxlength="50" placeholder="Masukkan nama mahasiswa">
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