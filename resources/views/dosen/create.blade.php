@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>{{ isset($detailDosen) ? 'Edit' : 'Tambah' }} Dosen</h1>
    <div class="card">
        <div class="card-header">{{ isset($detailDosen) ? 'Edit' : 'Tambah' }} Dosen</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailDosen) ? route('dosen.update', ['nidn' => $detailDosen->nidn]) : route('dosen.store') }}">
                @csrf
                @if(isset($detailDosen))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">NIDN</label>
                    <input type="text" class="form-control" name="nidn"
                        value="{{ old('nidn', $detailDosen->nidn ?? '') }}"
                        maxlength="10"
                        {{ isset($detailDosen) ? '' : '' }}>
                    @error('nidn')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama"
                        value="{{ old('nama', $detailDosen->nama ?? '') }}"
                        maxlength="50">
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