@extends('layouts.main')
@section('title', 'Tambah Pengumuman')

@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('pengumuman.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header"><h4>Tambah Pengumuman</h4></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pengirim</label>
                        <input type="text" name="pengirim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
             <label>Tanggal dan Waktu</label>
            <input type="datetime-local" name="created_at" class="form-control">
</div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
