@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1>{{ isset($detailKrs) ? 'Edit' : 'Tambah' }} KRS</h1>
    <div class="card">
        <div class="card-header">{{ isset($detailKrs) ? 'Edit' : 'Tambah' }} KRS</div>
        <div class="card-body">

            <form method="POST" action="{{ isset($detailKrs) ? route('krs.update', ['id' => $detailKrs->id]) : route('krs.store') }}">
                @csrf
                @if(isset($detailKrs))
                    @method('PUT')
                @endif

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

                <div class="mb-3">
                    <label class="form-label">Matakuliah</label>
                    <select name="kode_matakuliah" class="form-select">
                        <option value="">-- Pilih Matakuliah --</option>
                        @foreach($matakuliah as $mk)
                            <option value="{{ $mk->kode_matakuliah }}"
                                {{ old('kode_matakuliah', $detailKrs->kode_matakuliah ?? '') == $mk->kode_matakuliah ? 'selected' : '' }}>
                                {{ $mk->nama_matakuliah }} ({{ $mk->kode_matakuliah }})
                            </option>
                        @endforeach
                    </select>
                    @error('kode_matakuliah')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('krs.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection