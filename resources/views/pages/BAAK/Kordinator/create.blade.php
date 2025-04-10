@extends('layouts.main')
@section('title', 'Create    Kordinator')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Kordinator</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('koordinator.index') }}">Kembali</a>
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

                        <form method="POST" action="{{ route('koordinator.store')}}" enctype="multipart/form-data">
                            @csrf
                       
                            {{-- Pilih Dosen --}}
                            <div class="form-group">
                                <label for="user_id">Pilih Dosen</label>
                                <select id="user_id" name="user_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosen as $item)
                                        <option 
                                            value="{{ $item['user_id'] }}"
                                            data-nama="{{ $item['nama'] }}"
                                            {{ $item['user_id'] == $dosenRole['user_id'] ? 'selected' : '' }}
                                        >
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="nama" id="nama_dosen" value="{{ $dosenRole['nama_dosen'] }}">
                            </div>

                            {{-- Role Koordinator (Hidden) --}}
                            <div class="form-group">
                                <input type="hidden" name="role_id" value="1">
                                <input type="hidden" name="role_name" value="Koordinator">
                            </div>

                            {{-- Prodi --}}
                            <div class="form-group">
                                <label for="prodi_id">Pilih Prodi</label>
                                <select id="prodi_id" name="prodi" class="select2 form-control" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    <option value="DIV Teknologi Rekayasa Perangkat Lunak" {{ $dosenRole['prodi'] == 'DIV Teknologi Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Teknologi Rekayasa Perangkat Lunak</option>
                                    <option value="DIII Teknologi Informasi" {{ $dosenRole['prodi'] == 'DIII Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                                    <option value="DIII Teknologi Komputer" {{ $dosenRole['prodi'] == 'DIII Teknologi Komputer' ? 'selected' : '' }}>Teknologi Komputer</option>
                                </select>
                            </div>

                            {{-- Tingkat --}}
                            <div class="form-group">
                                <label for="jenis_pa_id">Kategori Proyek</label>
                                <select id="jenis_pa_id" name="jenis_pa" class="select2 form-control" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="PA-1" {{ $dosenRole['jenis_pa'] == 1 ? 'selected' : '' }}>PA-1</option>
                                    <option value="PA-2" {{ $dosenRole['jenis_pa'] == 2 ? 'selected' : '' }}>PA-2</option>
                                    <option value="PA-3" {{ $dosenRole['jenis_pa'] == 3 ? 'selected' : '' }}>PA-3</option>
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
