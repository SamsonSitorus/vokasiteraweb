@extends('layouts.main')
@section('title', 'List Kelompok')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary"><i class="fas fa-tasks"></i> &nbsp;List Tugas</h4>
                        <a href="{{ route('tugas.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-folder-plus"></i>&nbsp; Tambah Tugas
                        </a>
                    </div> 
                    <div class="card-body">
                        @include('partials.alert')
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="table-2">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Judul Tugas</th>
                                        <th>Instruksi</th>
                                        <th>Status</th>
                                        <th style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($artefak as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->Judul_Tugas }}</td>
                                        <td>{{ Str::limit($item->Deskripsi_Tugas, 60) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td class="text-center">
                                            <a href="{{-- route('tugas.submit', $item->id) --}}" class="btn btn-sm btn-info">
                                                <i class="fas fa-upload"></i> Submit
                                            </a>
                                            {{-- Tambahkan tombol edit/hapus jika diperlukan --}}
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
            title: `Yakin ingin menghapus data ini?`,
            text: "Data akan terhapus secara permanen!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
@endpush
