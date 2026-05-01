@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>{{ isset($detailMatakuliah) ? 'Edit' : 'Tambah' }} Matakuliah</h1>
    <div class="card">
        <div class="card-header">{{ isset($detailMatakuliah) ? 'Edit' : 'Tambah' }} Matakuliah</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailMatakuliah) ? route('matakuliah.update', ['kode' => $detailMatakuliah->kode_matakuliah]) : route('matakuliah.store') }}">
                @csrf
                @if(isset($detailMatakuliah))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Kode Matakuliah</label>
                    <input type="text" class="form-control" name="kode_matakuliah"
                        value="{{ old('kode_matakuliah', $detailMatakuliah->kode_matakuliah ?? '') }}"
                        maxlength="8"
                        {{ isset($detailMatakuliah) ? '' : '' }}>
                    @error('kode_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Matakuliah</label>
                    <input type="text" class="form-control" name="nama_matakuliah"
                        value="{{ old('nama_matakuliah', $detailMatakuliah->nama_matakuliah ?? '') }}"
                        maxlength="50">
                    @error('nama_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" class="form-control" name="sks"
                        value="{{ old('sks', $detailMatakuliah->sks ?? '') }}"
                        min="1" max="6">
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