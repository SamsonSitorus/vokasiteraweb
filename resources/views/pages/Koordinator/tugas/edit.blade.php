@extends('layouts.main')
@section('title', 'Edit Tugas')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Tugas</h4>
                        <a href="{{ route('tugas.tugas') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tugas.update', $tugas->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="file">File Tugas</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" id="file">
                                        <label class="custom-file-label" for="file">
                                            {{ $tugas->file ? basename($tugas->file) : 'Pilih file' }}
                                        </label>
                                    </div>
                                </div>
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                       placeholder="Judul tugas" value="{{ old('judul', $tugas->judul) }}">
                                @error('judul')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="instruksi">Instruksi</label>
                                <textarea id="instruksi" name="instruksi" class="form-control @error('instruksi') is-invalid @enderror"
                                          placeholder="Instruksi tugas">{{ old('instruksi', $tugas->instruksi) }}</textarea>
                                @error('instruksi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="batas">Batas Waktu</label>
                                <input type="datetime-local" id="batas" name="batas" class="form-control @error('batas') is-invalid @enderror"
                                       value="{{ old('batas', \Carbon\Carbon::parse($tugas->batas)->format('Y-m-d\TH:i')) }}">
                                @error('batas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
