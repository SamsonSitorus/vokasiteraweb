@extends('layouts.main')
@section('title', 'Detail Pengumuman')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pengumuman</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" value="{{ $pengumuman->judul }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Pengirim</label>
                                    <input type="text" class="form-control" value="{{ $pengumuman->pengirim }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" value="{{ $pengumuman->created_at->format('d-m-Y') }}" readonly>
                                </div>
                            </div>
                            

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" rows="5" readonly>{{ $pengumuman->deskripsi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($pengumuman->status) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Download File jika ada -->
                        @if ($pengumuman->file)
                            <div class="text-center mt-4">
                                <a href="{{ asset('storage/' . $pengumuman->file) }}" class="btn btn-success" download>
                                    <i class="fas fa-file-download"></i> Download File
                                </a>
                            </div>
                        @endif
                        <div class="text-center mt-3">
                        <a href="{{ route('pengumuman.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                      </a>
                     </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
