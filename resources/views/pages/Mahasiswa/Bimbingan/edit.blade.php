@extends('layouts.main')
@section('title', 'Edit Kelompok')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Kelompok</h4>
                        <a href="{{ route('bimbingan.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{--  --}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Keperluan --}}   
                            <div class="form-group">
                                <label for="keperluan">Keperluan</label>
                                <input type="text" name="keperluan" id="keperluan" class="form-control @error('keperluan') is-invalid @enderror" placeholder="Masukkan keperluan " value="{{ old('keperluan', $bimbingan->keperluan) }}">
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                              {{-- rencana mulai --}}
                            <div class="form-group">
                                <label for="rencana_mulai">Rencana Bimbingan</label>
                                <input type="datetime-local" name="rencana_mulai" id="rencana_mulai" class="form-control @error('rencana_mulai') is-invalid @enderror" value="{{ old('Judul_Tugas', $bimbingan  ->rencana_mulai) }}">
                                @error('rencana_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                               {{-- rencana selesai --}}
                               <div class="form-group">
                                <label for="rencana_selesai">Rencana Selesai</label>
                                <input type="datetime-local" name="rencana_selesai" id="rencana_selesai" class="form-control @error('rencana_selesai') is-invalid @enderror" value="{{ old('Judul_Tugas', $bimbingan  ->rencana_selesai) }}">
                                @error('rencana_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- lokasi --}}
                            <div class="form-group">
                                <label for="lokasi">lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="Masukkan lokasi " value="{{ old('lokasi', $bimbingan->lokasi) }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                       

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
