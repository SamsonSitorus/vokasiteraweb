@extends('layouts.main')
@section('title', 'Jadwal')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Jadwal</h4>
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
                            <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Jadwal
                        </a>
                    </div>                    
                    <div class="card-body">
                        @include('partials.alert')
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Kelompok</th>
                                        <th>Tanggal</th>
                                        <th>Dosen Penguji</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($jadwal as $item)
                                        <tr>
                                            <!-- <td>{{ $item->id }}</td> -->
                                            <td>{{ $item->kelompok_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->waktu)->format('d M Y H:i') }}</td>    
                                            <td>{{ $item->penguji1_nama }}, {{ $item->penguji2_nama }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{route('jadwal.edit', Crypt::encrypt($item->id))}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                    <form method="POST" action="{{route('jadwal.destroy', $item->id)}}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
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
