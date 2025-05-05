@extends('layouts.main')
@section('title', 'Berikan Feedback')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Berikan Feedback - Kelompok {{ $pengumpulan->kelompok->nomor_kelompok }}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Judul Tugas:</strong> {{ $pengumpulan->tugas->Judul_Tugas }}</p>
                        <p><strong>File Tugas:</strong> 
                            <a href="{{ asset('storage/' . $pengumpulan->file_path) }}" target="_blank">Lihat File</a>
                        </p>
                        <form method="POST" action="{{ route('feedback.update', $pengumpulan->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="feedback">Feedback</label>
                                <textarea name="feedback" class="form-control" rows="5" required>{{ old('feedback', $pengumpulan->feedback) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan Feedback</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
