@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header">Form Tambah Dosen</div>
        <div class="card-body">

            <form method="POST" action="{{ route('dosen.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NIDN</label>
                    <input type="text" class="form-control" name="nidn" value="{{ old('nidn') }}" maxlength="10" placeholder="Masukkan NIDN (10 digit)">
                    @error('nidn')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" maxlength="50" placeholder="Masukkan nama dosen">
                    @error('nama')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection