@extends('layouts.main')
@section('title', 'Tambah Jadwal')

@section('content') 
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Jadwal</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('jadwal.index') }}">Kembali</a>
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

                        <form method="POST" action="{{ route('jadwal.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Pilih Kelompok --}}
                            <div class="form-group">
                                <label for="kelompok_id">Pilih Kelompok</label>
                                <select name="kelompok_id" id="kelompok_id" class="form-control" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    @foreach($kelompok as $item)
                                        <option value="{{ $item->id }}" 
                                            data-pembimbing="{{ $item->pembimbing_id }}"
                                            {{ old('kelompok_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nomor_kelompok }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Masukkan Lokasi --}}
                            <div class="form-group">
                                <label for="ruangan">Ruangan</label>
                                <select name="ruangan_id" id="ruangan_id" class="form-control" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($ruangan as $item)
                                    <option value="{{ $item->id}}" {{ old('ruangan_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->ruangan}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Masukkan Lokasi 
                            <div class="form-group">
                                <label for="ruangan">Lokasi</label>
                                <input type="text" name="ruangan" id="ruangan" class="form-control @error('ruangan') is-invalid @enderror" placeholder="Masukkan Ruangan" value="{{ old('ruangan') }}">
                                @error('ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            {{-- Masukkan Waktu --}}
                            <div class="form-group">
                                <label for="waktu">Tanggal</label>
                                <input type="datetime-local" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') ? \Carbon\Carbon::parse(old('waktu'))->format('Y-m-d\TH:i') : '' }}">
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Penguji 1 
                            <div class="form-group">
                                <label for="penguji1">Pilih Penguji 1</label>
                                <select id="penguji1" name="penguji1" class="select2 form-control" required>
                                    <option value="">-- Pilih Penguji 1 --</option>
                                    @foreach ($dosenFinal as $item)
                                        <option value="{{ $item['user_id'] }}" {{ old('penguji1') == $item['user_id'] ? 'selected' : '' }}>
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>--}}

                            {{-- Pilih Penguji 2 
                            <div class="form-group">
                                <label for="penguji2">Pilih Penguji 2</label>
                                <select id="penguji2" name="penguji2" class="select2 form-control" required>
                                    <option value="">-- Pilih Penguji 2 --</option>
                                    @foreach ($dosenFinal as $item)
                                        <option value="{{ $item['user_id'] }}" {{ old('penguji2') == $item['user_id'] ? 'selected' : '' }}>
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>--}}

                            {{-- Tahun Masuk --}}
                            <div class="form-group">
                                <label>Tahun Masuk</label>
                                <input type="text" class="form-control" value="{{ $tahunMasuk->Tahun_Masuk }}" disabled>
                                <input type="hidden" name="TM_id" value="{{ $tahunMasuk->id }}">
                            </div>

                            {{-- Program Studi --}}
                            <div class="form-group">
                                <label>Program Studi</label>
                                <input type="text" class="form-control" value="{{ $prodi->nama_prodi }}" disabled>
                                <input type="hidden" name="prodi_id" value="{{ $prodi->id }}">
                            </div>

                            {{-- Kategori PA--}}
                            <div class="form-group">
                                <label>Jenis PA</label>
                                <input type="text" class="form-control" value="{{ $kategoriPA->kategori_pa }}" disabled>
                                <input type="hidden" name="KPA_id" value="{{ $kategoriPA->id }}">
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
        const kelompokSelect = document.getElementById('kelompok_id');
        const penguji1Select = document.getElementById('penguji1');
        const penguji2Select = document.getElementById('penguji2');

        function disablePembimbingOptions() {
            const selectedOption = kelompokSelect.options[kelompokSelect.selectedIndex];
            const pembimbingId = selectedOption.getAttribute('data-pembimbing');

            [...penguji1Select.options, ...penguji2Select.options].forEach(opt => {
                opt.disabled = false;
            });

            if (pembimbingId) {
                [...penguji1Select.options, ...penguji2Select.options].forEach(opt => {
                    if (opt.value === pembimbingId) {
                        opt.disabled = true;
                    }
                });
            }
        }

        kelompokSelect.addEventListener('change', disablePembimbingOptions);
        disablePembimbingOptions(); 
    });
</script>
@endpush
