@extends('layouts.main')
@section('title', 'Edit Koordinator')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Koordinator</h4>
                        <a href="{{ route('koordinator.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('koordinator.update', Crypt::encrypt($dosenRole['id'])) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Pilih Dosen --}}
                            <div class="form-group">
                                <label for="user_id">Pilih Dosen</label>
                                <select id="user_id" name="user_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosen as $item)
                                    <option 
                                    value="{{ $item['user_id'] ?? '' }}"
                                    data-nama="{{ $item['nama'] ?? 'Tanpa Nama' }}"
                                    {{ $item['user_id'] == $dosenRole['user_id'] ? 'selected' : '' }}
                                >
                                    {{ $item['nama'] ?? 'Tanpa Nama' }}
                                </option>
                                @endforeach
                                </select>
                                {{-- Hidden input nama dosen --}}
                            <input type="hidden" name="nama" id="nama_dosen" value="{{ $dosenRole['nama_dosen'] }}">

                            </div>

                              <div class="form-group">
                                <input type="hidden" name="role_id" value="1">
                                <input type="hidden" name="role_name" value="Koordinator">
                            </div>

                            {{-- Pilih Prodi --}}
                            <div class="form-group">
                                <label for="prodi_id">Pilih Prodi</label>
                                <select id="prodi_id" name="prodi" class="select2 form-control" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    <option value="TRPL" {{ $dosenRole['prodi'] == 'TRPL' ? 'selected' : '' }}>Teknologi Rekayasa Perangkat Lunak</option>
                                    <option value="TI"   {{ $dosenRole['prodi'] == 'TI' ? 'selected' : '' }}>Teknologi Informasi</option>
                                    <option value="TK"   {{ $dosenRole['prodi'] == 'TK' ? 'selected' : '' }}>Teknologi Komputer</option>
                                </select>
                            </div>

                            {{-- Pilih Tingkat --}}
                            <div class="form-group">
                                <label for="tingkat_id">Pilih Tingkat</label>
                                <select id="tingkat_id" name="tingkat" class="select2 form-control" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="1" {{ $dosenRole['tingkat'] == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $dosenRole['tingkat'] == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $dosenRole['tingkat'] == 3 ? 'selected' : '' }}>3</option>
                                </select>
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

        updateNama(); // Set nama saat load
        select.addEventListener('change', updateNama); // Update nama saat ganti dosen
    });
</script>
@endpush
