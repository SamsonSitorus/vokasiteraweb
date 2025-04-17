@extends('layouts.main')
@section('title', 'Edit Pembimbing')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Pembimbing</h4>
                        <a href="{{--  --}}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{-- route('pembimbing.update', Crypt::encrypt($dosenRole['id'])) --}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Pilih Dosen --}}
                            <div class="form-group">
                                <label for="user_id">Pilih Dosen</label>
                                <select id="user_id" name="user_id" class="select2 form-control" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($pembimbing as $item)
                                    <option 
                                        value="{{$item->id }}" 
                                    >
                                        {{ $item['user_id'] }}
                                    </option>
                                @endforeach
                               

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('user_id');
        const namaInput = document.getElementById('nama_dosen');

        function updateNama() {
            const selected = select.options[select.selectedIndex];
            const nama = selected.getAttribute('data-nama') || '';
            namaInput.value = nama;
        }

        updateNama(); // Set nama saat load
        select.addEventListener('change', updateNama); // Update nama saat ganti dosen
    });
</script>
@endpush
