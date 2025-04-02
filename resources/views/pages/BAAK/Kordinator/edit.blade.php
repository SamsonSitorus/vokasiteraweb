@extends('layouts.main')
@section('title', 'Edit tugas')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alert')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Kelompok {{-- $tugas->judul --}}</h4>
                            <a href="{{-- route('tugas.index') --}}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{-- route('tugas.update', $tugas->id) --}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                 {{-- <div class="form-group">
                                    <label for="foto">File Tugas</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="file" type="file" name="file" class="form-control @error('file') is-invalid @enderror" id="file" value="{{ $tugas->file ?? '' }}">
                                            <label class="custom-file-label" for="file">{{ $tugas->file ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="{{ __('Judul tugas') }}" value="{{ $tugas->judul ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="{{ __('Deskripsi tugas') }}">{{ $tugas->deskripsi ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kelas --</option>
                                        {{-- @foreach ($kelas as $data )
                                            <option value="{{ $data->id }}"
                                            @if ($tugas->kelas_id == $data->id)
                                                selected
                                            @endif
                                        >{{ $data->nama_kelas ?? '' }}</option>
                                        @endforeach 
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="judul">Nomor Kelompok</label>
                                    <input type="text" id="nomor kelompok" name="nomor kelompok" class="form-control @error('nomor kelompok') is-invalid @enderror" placeholder="{{ __('Nomor Kelompok ') }}">
                                </div>
                                <div class="form-group">
                                    <label for="kelas_id">Pilih MahaSiswa 1 </label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa 1--</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                                    <label for="kelas_id">Pilih MahaSiswa 2</label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa 2 --</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                           
                                    <label for="kelas_id">Pilih MahaSiswa 3 </label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa  3--</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                              
                                    <label for="kelas_id">Pilih MahaSiswa 4</label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa  4--</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                               
                                    <label for="kelas_id">Pilih MahaSiswa 5</label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa 5 --</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                         
                                    <label for="kelas_id">Pilih MahaSiswa 6</label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih MahaSiswa 6 --</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
