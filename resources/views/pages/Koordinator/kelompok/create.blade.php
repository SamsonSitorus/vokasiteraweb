@extends('layouts.main')
@section('title', 'Tambah Koordinator')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Koordinator</h4>
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

                        <form method="POST" action="{{-- route('kelompok.store') --}}" enctype="multipart/form-data">
                            @csrf
                            {{-- Nomor Kelompok --}}
                            <div class="form-group">
                                <label for="nomor_kelompok">Nomor Kelompok</label>
                                <input type="text" name="nomor_kelompok" id="nomor_kelompok" class="form-control" required>
                            </div>

                            {{-- Tahun Angkatan --}}
                            <div class="form-group">
                                <label for="angkatan">Tahun Angkatan</label>
                                <input type="number" name="angkatan" id="angkatan" class="form-control" required>
                            </div>

                            {{-- Prodi --}}
                            <div class="form-group">
                                <label for="prodi_id">Pilih Prodi</label>
                                <select id="prodi_id" name="prodi" class="select2 form-control" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    <option value="DIV Teknologi Rekayasa Perangkat Lunak">DIV Teknologi Rekayasa Perangkat Lunak</option>
                                    <option value="DIII Teknologi Komputer">DIII Teknologi Komputer</option>
                                    <option value="DIII Teknologi Informasi">DIII Teknologi Informasi</option>
                                </select>
                            </div>

                            {{-- Kategori PA --}}
                            <div class="form-group">
                                <label for="jenis_pa_id">Kategori PA</label>
                                <select id="jenis_pa_id" name="jenis_pa" class="select2 form-control" required>
                                    <option value="">-- Pilih Kategori PA --</option>
                                    <option value="1">PA-1</option>
                                    <option value="2">PA-2</option>
                                    <option value="3">PA-3</option>
                                </select>
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

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('user_id');
        const namaInput = document.getElementById('nama_dosen');

        function updateNama() {
            const selected = select.options[select.selectedIndex];
            const nama = selected.getAttribute('data-nama') || '';
            namaInput.value = nama;
        }

        updateNama();
        select.addEventListener('change', updateNama);
    });
</script>
@endpush
