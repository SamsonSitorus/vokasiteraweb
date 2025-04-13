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
                        <a class="btn btn-primary btn-sm" href="{{ route('kelompokmahasiswa.index') }}">Kembali</a>
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
                            <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">

                            @for ($i = 1; $i <= 6; $i++)
                            <div class="form-group">
                                <label for="user_id_{{ $i }}">Pilih Mahasiswa {{ $i }}</label>
                                <select id="user_id_{{ $i }}" name="user_id[]" class="select2 form-control">
                                    <option value="">-- Pilih Mahasiswa {{ $i }} --</option>
                                    @foreach ($mahasiswa as $item)
                                        <option value="{{ $item['user_id'] }}">
                                            {{ $item['nama'] }} - {{ $item['nim'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endfor
                        
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
    