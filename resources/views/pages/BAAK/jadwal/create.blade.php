@extends('layouts.main')
@section('title', 'Jadwal Staff')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Tambah Jadwal</h4>
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

                        <form method="POST" action="{{ route('baak.jadwal.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Pilih Prodi --}}
                            <div class="form-group">
                                <label for="prodi_id">Pilih Prodi</label>
                                <select id="prodi_id" name="prodi_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id }}" {{ old('prodi_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="form-group">
                                <label for="TA_id">Tahun Ajaran</label>
                                <select name="TA_id" id="TA_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Tahun Masuk --</option>
                                    @foreach ($tahun_ajaran as $item)
                                        <option value="{{ $item->id }}" {{ old('TA_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->Tahun_Ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kategori Proyek Akhir --}}
                            <div class="form-group">
                                <label for="KPA_id">Kategori Proyek Akhir</label>
                                <select id="KPA_id" name="KPA_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Kategori Proyek Akhir --</option>
                                    @foreach ($kategori_pa as $item)
                                        <option value="{{ $item->id }}" {{ old('KPA_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->kategori_pa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Pilih Kelompok --}}
                            <div class="form-group">
                                <label for="kelompok_id">Pilih Kelompok</label>
                                <select name="kelompok_id" id="kelompok_id" class="form-control" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    {{-- Akan terisi otomatis via JS --}}
                                </select>
                            </div>

                            {{-- Masukkan Lokasi --}}
                            <div class="form-group">
                                <label for="ruangan">Lokasi</label>
                                <input type="text" name="ruangan" id="ruangan" class="form-control @error('ruangan') is-invalid @enderror" placeholder="Masukkan Ruangan" value="{{ old('ruangan') }}">
                                @error('ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Masukkan Jam --}}
                            <div class="form-group">
                                <label for="waktu">Tanggal</label>
                                <input type="datetime-local" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') ? \Carbon\Carbon::parse(old('waktu'))->format('Y-m-d\TH:i') : '' }}">
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Penguji 1 --}}
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
                            </div>

                            {{-- Pilih Penguji 2 --}}
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
    $(document).ready(function () {
        function loadKelompok() {
            const prodi_id = $('#prodi_id').val();
            const KPA_id = $('#KPA_id').val();
            const TA_id = $('#TA_id').val();

            if (prodi_id && KPA_id && TA_id) {
                $.ajax({
                    url: "{{ route('baak.jadwal.getKelompok') }}",
                    method: "GET",
                    data: {
                        prodi_id: prodi_id,
                        KPA_id: KPA_id,
                        TA_id: TA_id
                    },
                    success: function (response) {
                        const kelompokSelect = $('#kelompok_id');
                        kelompokSelect.empty();
                        kelompokSelect.append('<option value="">-- Pilih Kelompok --</option>');
                        response.forEach(function (item) {
                        kelompokSelect.append(`<option value="${item.id}">${item.text}</option>`);
                    });
                    },
                    error: function (xhr) {
                        alert('Gagal mengambil data kelompok');
                    }
                });
            }
        }

        $('#prodi_id, #KPA_id, #TA_id').change(loadKelompok);
    });
</script>
@endpush
