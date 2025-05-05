@extends('layouts.main')
@section('title', 'Edit Jadwal')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Jadwal</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('baak.jadwal.index') }}">Kembali</a>
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
                        <form method="POST" action="{{ route('baak.jadwal.update', Crypt::encrypt($jadwal->id)) }}"> 
                            @csrf
                            @method('PUT')
                            {{-- Pilih Prodi --}}
                            <div class="form-group">
                                <label for="prodi_id">Program Studi</label>
                                <input type="hidden" name="prodi_id" value="{{ old('prodi_id', $jadwal->prodi_id) }}" required>
                                <input type="text" class="form-control" value="{{ $jadwal->prodi->nama_prodi ?? 'Data tidak ditemukan' }}" disabled>
                            </div>
                            {{-- Pilih Tahun Ajaran --}}
                            <div class="form-group">
                                <label for="TM_id">Tahun Ajaran</label>
                                <input type="hidden" name="TM_id" value="{{ old('TM_id', $jadwal->TM_id) }}" required>
                                <input type="text" class="form-control" value="{{ $jadwal->tahunMasuk->Tahun_Masuk?? 'Data tidak ditemukan'}}" disabled>
                            </div>
                            {{-- Pilih Kategori PA --}}
                            <div class="form-group">
                                <label for="KPA_id">Kategori PA</label>
                                <input type="hidden" name="prodi_id" value="{{ old('prodi_id', $jadwal->prodi_id) }}" required>
                                <input type="text" class="form-control" value="{{ $jadwal->KategoriPA->kategori_pa ?? 'Data tidak ditemukan' }}" disabled>
                            </div>
                            {{--Pilih Kelompok--}}
                            <div class="form-group">
                            <label for="kelompok_id">Kelompok</label>
                            <input type="hidden" name="kelompok_id" value="{{ old('kelompok_id', $jadwal->kelompok_id) }}" required>
                            <input type="text" class="form-control" value="{{ $jadwal->kelompok->nomor_kelompok ?? 'Data tidak ditemukan' }}" disabled>
                            </div>

                            {{--Masukkan lokasi--}}
                            <div class="form-group mt-3">
                                <label for="ruangan">Lokasi</label>
                                <input type="text" name="ruangan" id="ruangan"
                                    class="form-control @error('ruangan') is-invalid @enderror"
                                    placeholder="Masukkan Ruangan"
                                    value="{{ old('ruangan', $jadwal->ruangan) }}">
                                @error('ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{--Masukkan Jam--}}
                            <div class="form-group">
                                <label for="waktu">Tanggal</label>
                                <input type="datetime-local" name="waktu" id="waktu"
                                    class="form-control @error('waktu') is-invalid @enderror"
                                    value="{{ old('waktu', \Carbon\Carbon::parse($jadwal->waktu)->format('Y-m-d\TH:i')) }}">
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
                                        <option 
                                            value="{{ $item['user_id'] }}" 
                                            {{ (old('penguji1') ?? $jadwal->penguji1) == $item['user_id'] ? 'selected' : '' }}
                                        >
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
                                        <option 
                                            value="{{ $item['user_id'] }}" 
                                            {{ (old('penguji2') ?? $jadwal->penguji2) == $item['user_id'] ? 'selected' : '' }}
                                        >
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>--}}
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
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
            const selected = select?.options[select.selectedIndex];
            const nama = selected?.getAttribute('data-nama') || '';
            if(namaInput) namaInput.value = nama;
        }

        updateNama();
        if(select) select.addEventListener('change', updateNama);
    });
</script>
@endpush
