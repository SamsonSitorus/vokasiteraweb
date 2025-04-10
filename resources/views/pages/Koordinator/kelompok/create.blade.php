@extends('layouts.main')
@section('title', 'Tambah Kelompok')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Kelompok</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('kelompok.index') }}">Kembali</a>
                    </div>  
                    <div class="card-body">

                        {{-- Tampilkan Error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('kelompok.store')}}" enctype="multipart/form-data">
                            @csrf

                            {{-- Nomor Kelompok --}}
                            <div class="form-group">
                                <label for="nomor">Nomor Kelompok</label>
                                <input type="text" name="nomor" id="nomor" class="form-control" required>
                            </div>

                            {{-- Tahun Angkatan --}}
                            <div class="form-group">
                                <label for="angkatan">Tahun Angkatan</label>
                                <input type="number" name="angkatan" id="angkatan" class="form-control" required>
                            </div>

                            {{-- Prodi (readonly) --}}
                            <div class="form-group">
                                <label for="prodi">Program Studi</label>
                                <input type="text" class="form-control" value="{{ session('prodi') }}" readonly>
                            </div>

                            {{-- Jenis PA (readonly) --}}
                            <div class="form-group">
                                <label for="jenis_pa">Jenis PA</label>
                                <input type="text" class="form-control" value="{{ session('jenis_pa') }}" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
    