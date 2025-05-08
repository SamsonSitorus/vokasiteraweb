    @extends('layouts.main')
    @section('title', 'Tugas')

    @section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Proyek Akhir</h4>
                        </div>                    
                        <div class="card-body">
                            @include('partials.alert')
<<<<<<< Updated upstream
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Submission</th>
                                            <th>DEADLINE</th>
                                            <th>SUBMISSION STATUS</th>
                                            <th>Feedback Koordinator</th>
                                            <th>Feedback Pembimbing</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($artefak as $item)
                                        @php
                                            $status = $statusByTugas->get($item->id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="submission-title font-weight-bold text-primary">{{ $item->Judul_Tugas }}</div>
                                                <div>{{ $item->Deskripsi_Tugas }}</div>
                                            </td>
                                            <td>
                                                <div>{{ $item->formatted_deadline }}</div>
                                                <div class="{{ $item->status_class }}">
                                                    ⏳ <span class="countdown" data-deadline="{{ $item->tanggal_pengumpulan }}"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $status ? $status->status : 'Belum dikumpulkan' }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $status && isset($statusByTugas[$item->id]) ? $statusByTugas[$item->id]->feedback : '-' }}
                                            </td>
                                            <td>
                                                {{ $status && $status->feedback_pembimbing ? $status->feedback_pembimbing : '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('artefak.create', Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    </tbody>                                
                                </table>
=======
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs mb-4" style="border-bottom: 1px solid #ddd;">
                                        <li class="nav-item">
                                            <a class="nav-link {{--  --}}" href="{{route('tugas.index')}}">
                                                PENGUMPULAN BERKAS
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{--  --}}" href="{{route('status_perizinan')}}">
                                                STATUS PERIZINAN MAJU SIDANG
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{--  --}}" href="{{ route('jadwal.seminar')}}">
                                                JADWAL SIDANG
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{--  --}}" href="{{route('revisi.index')}}">
                                                BERKAS FINAL
                                            </a>
                                        </li>
                                    </ul>
                    {{-- Konten Utama --}}
                        <div class="card">
                            <div class="card-body">
                                @foreach ($artefak as $item)
                                    @php
                                        $status = $statusByTugas->get($item->id);
                                    @endphp
                                    <div class="card mb-4 shadow-sm border">
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold">{{ $item->Judul_Tugas }}</h5>
                                            <p class="mb-2">{{ $item->Deskripsi_Tugas }}</p>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <strong>Deadline:</strong> 
                                                    <span class="text-danger">{{ $item->formatted_deadline }}</span>
                                                </li>
                                            </ul>
                                            <div class="mb-2">
                                                <span class="badge badge-{{ $status ? 'success' : 'secondary' }}">
                                                    {{ $status ? $status->status : 'Belum dikumpulkan' }}
                                                </span>
                                                <a href="{{ route('artefak.create', Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-primary ml-2">Lihat Detail</a>
                                            </div>
                                            <div class="mb-2 {{ $item->status_class }}">
                                                ⏳ <span class="countdown" data-deadline="{{ $item->tanggal_pengumpulan }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($artefak->isEmpty())
                                    <div class="alert alert-info">Tidak ada tugas yang tersedia.</div>
                                @endif

                            </div>
                        </div>

>>>>>>> Stashed changes
                            </div>
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
