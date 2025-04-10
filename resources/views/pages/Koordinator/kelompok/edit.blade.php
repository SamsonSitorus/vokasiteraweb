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
                        <a href="{{ route('kelompok.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('kelompok.update', Crypt::encrypt($kelompok['id'])) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                            {{-- Prodi --}}
                            <div class="form-group">
                                <label for="prodi">Program Studi</label>
                                <input type="text" name="prodi" id="prodi" class="form-control" value="{{ session('prodi') }}" readonly>
                            </div>

                            {{-- Jenis PA --}}
                            <div class="form-group">
                                <label for="jenis_pa">Jenis PA</label>
                                <input type="text" name="jenis_pa" id="jenis_pa" class="form-control" value="{{ session('jenis_pa') }}" readonly>
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
