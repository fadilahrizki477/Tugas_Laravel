@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header">Form Tambah Matakuliah</div>
        <div class="card-body">

            <form method="POST" action="{{ route('matakuliah.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Kode Matakuliah</label>
                    <input type="text" class="form-control" name="kode_matakuliah" value="{{ old('kode_matakuliah') }}" maxlength="8" placeholder="Contoh: MK001">
                    @error('kode_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Matakuliah</label>
                    <input type="text" class="form-control" name="nama_matakuliah" value="{{ old('nama_matakuliah') }}" maxlength="50" placeholder="Masukkan nama matakuliah">
                    @error('nama_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" class="form-control" name="sks" value="{{ old('sks') }}" min="1" max="6" placeholder="Jumlah SKS">
                    @error('sks')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection