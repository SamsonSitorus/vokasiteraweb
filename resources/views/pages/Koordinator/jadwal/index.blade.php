@extends('layouts.main')
@section('title','Jadwal')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Jadwal Seminar</h1>
    </div>

    <div class="card border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Jadwal Seminar</h5>
            <a href="{{ route('jadwal.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus-square"></i> Tambah Jadwal
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kelompok</th>
                        <th>Tanggal</th>
                        <th>Dosen Penguji</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->judul ?? 'Kelompok '.$index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMMM Y, HH.mm') }} - {{ $item->jam }}</td>
                            <td>
                                1. {{ $item->penguji1 }} <br>
                                2. {{ $item->penguji2 }} <br>
                                3. {{ $item->penguji3 }}
                            </td>
                            <td>
                                <a href="{{ route('jadwal.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data jadwal</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
