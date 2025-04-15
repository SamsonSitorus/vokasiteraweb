@extends('layouts.main')
@section('title', 'Pengumuman')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Daftar Pengumuman</h4>
                        <a href="{{ route('pengumuman.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i> Tambah Pengumuman
                        </a>
                    </div>
                    <div class="card-body">
                        @include('partials.alert') <!-- Menampilkan alert -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Pengirim</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
    @forelse ($pengumuman as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->pengirim }}</td>
            <td>{{ Str::limit($item->deskripsi, 50) }}</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
            <td>
                <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
            <td>
                <div class="d-flex gap-1">
                    <!-- Edit Button -->
                    <a href="{{ route('pengumuman.edit', $item->pengumuman_id) }}" class="btn btn-warning btn-sm">
                        <i class="nav-icon fas fa-edit"></i>&nbsp; Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('pengumuman.destroy', $item->pengumuman_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="nav-icon fas fa-trash-alt"></i>&nbsp; Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data pengumuman</td>
        </tr>
    @endforelse
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
    $(document).ready(function() {
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name"); // Menambahkan pengecekan nama jika diperlukan
            event.preventDefault(); // Menghentikan event default (submit form langsung)

            // Menampilkan SweetAlert
            swal({
                title: `Yakin ingin menghapus data ini?`,
                text: "Data akan terhapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit(); // Submit form jika tombol konfirmasi ditekan
                }
            });
        });
    });
</script>
@endpush
