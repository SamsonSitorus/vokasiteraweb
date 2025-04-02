@extends('layouts.main')
@section('title', 'List Kordinator')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List Kordinator</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Kelompok</button>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kordinator</th>
                                        <th>Angkatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   {{--@foreach ($tugas as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->judul }}</td>
                                        <td>{{ $data->kelas->nama_kelas }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-primary btn-sm mr-2" href="{{ route('tugas.show', $data->id) }}"><i class="nav-icon fas fa-eye"></i>&nbsp; Lihat jawaban</a>
                                                <a href="{{oute('tugas.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                <form method="POST" action="{{ route('tugas.destroy', $data->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Kordinator</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{-- <div class="modal-body">
                            <form action="{{-- route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                {{-- @foreach ($errors->all() as $error )
                                                {{ $error }}
                                                @endforeach }}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="kelas_id">Pilih Nomor Kelompok </label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih Nomor Kelompok--</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                      </div>
                                        <div class="form-group">
                                            <label for="kelas_id">Pilih MahaSiswa 1 </label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa 1--</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                            <label for="kelas_id">Pilih MahaSiswa 2</label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa 2 --</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                   
                                            <label for="kelas_id">Pilih MahaSiswa 3 </label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa  3--</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                      
                                            <label for="kelas_id">Pilih MahaSiswa 4</label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa  4--</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                       
                                            <label for="kelas_id">Pilih MahaSiswa 5</label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa 5 --</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                 
                                            <label for="kelas_id">Pilih MahaSiswa 6</label>
                                            <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih MahaSiswa 6 --</option>
                                                {{-- @forelse ($jadwal as $data )
                                                <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                @empty
                                                <option value="" disabled>Tidak ada kelas yang diajar</option>
                                                @endforelse }}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer br">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Yakin ingin menghapus data ini?`
                , text: "Data akan terhapus secara permanen!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

</script>
@endpush
