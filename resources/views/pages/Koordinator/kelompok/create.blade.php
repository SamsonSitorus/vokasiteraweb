@extends('layouts.main')
@section('title', 'List Kordinator')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tambah Kelompok</h4>
                            <a class="btn btn-primary btn-sm" href="{{-- route('tugas.index') --}}">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{-- route('tugas.store') --}}" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="kelas_id">Pilih Kelompok </label>
                                    <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kelompok --</option>
                                        {{-- @forelse ($jadwal as $data )
                                        <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                        @empty
                                        <option value="" disabled>Tidak ada kelas yang diajar</option>
                                        @endforelse --}}
                                    </select>
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section>
@endsection
