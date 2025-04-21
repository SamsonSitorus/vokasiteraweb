@extends('layouts.main')
@section('title', 'List Kelompok')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>List Bimbingan</h4>
                        <a href="{{ route('bimbingan.create') }}" class="btn btn-primary">
                            <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Request Bimbingan
                        </a>
                    </div>                    
                    <div class="card-body">
                        @include('partials.alert')
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>Submission</th>
                                        <th>DEADLINE</th>
                                        <th>SUBMISSION STATUS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Row 1 -->
                                    <tr>
                                        @foreach ($artefak as $item)
                                        <td>
                                            <div class="submission-title font-weight-bold text-primary">{{ $item->Judul_Tugas }}</div>
                                            <div>{{ $item->Deskripsi_Tugas }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $item->formatted_deadline }}</div>
                                            <div class="text-warning big">
                                                ⏳ <span class="countdown" data-deadline="{{ $item->tanggal_pengumpulan }}"></span>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">{{ $item->status }}</span></td>
                                        <td><a href="#" class="btn btn-sm btn-info">View</a></td>
                                        @endforeach
                                    </tr>
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
    $(document).on('click', '.show_confirm', function(event) {
        event.preventDefault();
        var form = $(this).closest("form");
        swal({
            title: "Yakin ingin menghapus data ini?",
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
    function updateCountdown() {
        const countdownEls = document.querySelectorAll('.countdown');

        countdownEls.forEach(el => {
            const deadline = new Date(el.dataset.deadline).getTime();
            const now = new Date().getTime();
            const diff = deadline - now;

            if (diff > 0) {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

                if (days > 0) {
                    el.textContent = `${days} hari ${hours} jam lagi`;
                } else {
                    el.textContent = `${hours} jam ${minutes} menit lagi`;
                }
            } else {
                const absDiff = Math.abs(diff);
                const hours = Math.floor((absDiff) / (1000 * 60 * 60));
                const minutes = Math.floor((absDiff % (1000 * 60 * 60)) / (1000 * 60));
                el.textContent = `Selesai ${hours} jam ${minutes} menit yang lalu`;
                el.classList.remove('text-warning');
                el.classList.add('text-success');
            }
        });
    }

    updateCountdown();
    setInterval(updateCountdown, 60000); // update tiap 1 menit
</script>

@endpush
