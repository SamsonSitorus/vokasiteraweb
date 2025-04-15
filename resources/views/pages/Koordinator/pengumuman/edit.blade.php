@extends('layouts.main')
@section('title', 'Edit Pengumuman')

@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('pengumuman.update', $pengumuman->pengumuman_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header"><h4>Edit Pengumuman</h4></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" value="{{ $pengumuman->judul }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pengirim</label>
                        <input type="text" name="pengirim" value="{{ $pengumuman->pengirim }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required>{{ $pengumuman->deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif" {{ $pengumuman->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $pengumuman->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
