@extends('layouts.main')
@section('title', 'Jadwal Mahasiswa')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Jadwal Mahasiswa</h4>
                    </div>                    
                    <div class="card-body">
                        @include('partials.alert')
                        @if(session('error'))
                        <div class="alert alert-warning">
                        {{ session('error') }}
                        </div>
                        @endif
                        @if(isset($jadwal))
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                <tr>
                                    <th>Nomor Kelompok</th>
                                    <td>{{ $jadwal->kelompok->nomor_kelompok ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Ruangan</th>
                                    <td>{{ $jadwal->ruangan }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Sidang</th>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->waktu)->translatedFormat('l, d F Y - H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Penguji 1</th>
                                    <td>{{ $jadwal->penguji1_nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Penguji 2</th>
                                    <td>{{ $jadwal->penguji2_nama ?? '-' }}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-info">
                                Jadwal belum tersedia untuk kelompok Anda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div class="container mt-4">
    <h3 class="mb-4">Jadwal Seminar</h3>

    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($jadwal))
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nomor Kelompok</th>
                        <td>{{ $jadwal->kelompok->nomor_kelompok ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ruangan</th>
                        <td>{{ $jadwal->ruangan }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Sidang</th>
                        <td>{{ \Carbon\Carbon::parse($jadwal->waktu)->translatedFormat('l, d F Y - H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Penguji 1</th>
                        <td>{{ $jadwal->penguji1_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penguji 2</th>
                        <td>{{ $jadwal->penguji2_nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Jadwal belum tersedia untuk kelompok Anda.
        </div>
    @endif
</div> -->
@endsection