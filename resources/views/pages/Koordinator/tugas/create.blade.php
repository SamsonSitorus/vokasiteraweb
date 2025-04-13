@extends('layouts.main')
@section('title', 'Tambah Tugas')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Tugas</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('tugas.tugas') }}">Kembali</a>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('tugas.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan Judul" value="{{ old('judul') }}">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="instruksi">Instruksi</label>
                                <input type="text" name="instruksi" id="instruksi" class="form-control @error('instruksi') is-invalid @enderror" placeholder="Masukkan Instruksi" value="{{ old('instruksi') }}">
                                @error('instruksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="batas">Batas Pengumpulan</label>
                                <input type="date" name="batas" id="batas" class="form-control @error('batas') is-invalid @enderror" value="{{ old('batas') }}">
                                @error('batas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="file">Dokumen</label>
                                <div class="border p-4 text-center" style="border: 2px dashed #ccc;">
                                    <i class="fas fa-upload fa-2x mb-2"></i>
                                    <p>Drag Your File Here</p>
                                    <p>Or</p>
                                    <label class="btn btn-primary">
                                        Select File
                                        <input type="file" name="file" id="file" class="d-none @error('file') is-invalid @enderror">
                                    </label>
                                </div>
                                @error('file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-2">Tambah</button>
                                <a href="{{ route('tugas.tugas') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
