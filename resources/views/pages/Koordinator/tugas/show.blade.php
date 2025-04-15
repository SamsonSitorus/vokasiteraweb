@extends('layouts.main')
@section('title', 'View')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Detail Tugas</h4>
                        <a class="btn btn-primary btn-sm" href="{{ route('tugas.tugas') }}">Kembali</a>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')
                        <table class="table table-bordered">
                            <tr>
                                <th>Judul</th>
                                <td>{{ $tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Instruksi</th>
                                <td>{{ $tugas->instruksi }}</td>
                            </tr>
                            <tr>
                                <th>File</th>
                                <td>
                                    @if ($tugas->file)
                                        <a href="{{ asset('storage/' . $tugas->file) }}" target="_blank" class="btn btn-info btn-sm">
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Batas Waktu</th>
                                <td>{{ \Carbon\Carbon::parse($tugas->batas)->format('d-m-Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
