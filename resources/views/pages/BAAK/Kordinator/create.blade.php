@extends('layouts.main')
@section('title', 'List Kordinator')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Kordinator</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('tugas.index') }}">Kembali</a>
                    </div>  
                    <div class="card-body">

                        {{-- Tampilkan Error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('dosen-role.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="user_id">Pilih Dosen</label>
                                <select id="user_id" name="user_id" class="select2 form-control">
                                    <option value="">-- Pilih Dosen --</option>
                                    @if (!empty($dosen) && is_array($dosen))
                                        @foreach ($dosen as $item)
                                        {{-- <option value="{{ $item['userid'] ?? '' }}">{{-- $item['nama'] ?? 'Tanpa Nama' }}</option> --}}
                                        <option value="{{ $item['user_id'] ?? '' }}">{{ $item['nama'] ?? 'Tanpa Nama' }}</option>

                                        @endforeach
                                    @else
                                        <option value="">Data dosen tidak tersedia</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="roles">Pilih Role</label><br>
                                @if (!empty($role) && is_array($role))
                                    @foreach ($role as $item)
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                name="role_id[]" 
                                                value="{{ $item['id'] ?? '' }}" 
                                                id="role_{{ $item['id'] ?? '' }}" 
                                                class="form-check-input">
                                            <label for="role_{{ $item['id'] ?? '' }}" class="form-check-label">
                                                {{ $item['role_name'] ?? 'Tanpa Nama' }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Data Role tidak tersedia</p>
                                @endif
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
