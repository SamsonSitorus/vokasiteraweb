@extends('layouts.main')

@section('title', 'Kartu Bimbingan')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Proyek Akhir 2</h4>
                        <p>Kartu Bimbingan</p>
                    </div>
                    <div class="card-body">
                        <!-- Menampilkan Kartu Bimbingan -->
                        <form method="POST" action="{{ route('bimbingan.update', Crypt::encrypt($bimbingan->id)) }}">
                        @csrf
                        @method('PUT')

                        <!-- Kelompok -->
                        <div class="form-group">
                            <label for="kelompok">Kelompok</label>
                            <input type="text" class="form-control" id="kelompok" value="{{ $bimbingan->kelompok->nomor_kelompok }}" readonly>
                        </div>

                        <!-- Pembimbing -->
                        <div class="form-group">
                            <label for="pembimbing">Pembimbing</label>
                            <input type="text" class="form-control" id="pembimbing" value="{{ $bimbingan->nama }}" readonly>
                        </div>

                        <!-- Anggota Kelompok -->
                        <div class="form-group">
                            <label for="anggota">Anggota</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mahasiswakelompoks as $item)
                                        <tr>
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tanggal Bimbingan -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" value="{{ now()->toDateString() }}" readonly>
                        </div>

                        <!-- Topic -->
                        <div class="form-group">
                            <label for="topic">Topic</label>
                            <input type="text" class="form-control" id="topic" value="{{ $bimbingan->keperluan }}" readonly>
                        </div>

                        <!-- Hasil Bimbingan -->
                        <div class="form-group">
                            <label for="hasil_bimbingan">Hasil Bimbingan</label>
                            <textarea class="form-control" id="hasil_bimbingan" rows="15" name="hasil_bimbingan" style="font-size: 16px; line-height: 1.5;">{{ $bimbingan->hasil_bimbingan }}</textarea>
                            <small class="form-text text-muted">
                                Format penomoran akan otomatis diatur saat disimpan. Gunakan baris baru untuk setiap poin.
                            </small>
                        </div>

                        <!-- Tanda Tangan Pembimbing -->
                        <div class="form-group">
                            <label for="pembimbing">Tanda Tangan Pembimbing</label>
                            <input type="text" class="form-control" id="pembimbing" value="{{ $bimbingan->nama }}" readonly>
                        </div>

                        <div class="d-flex justify-content-end">
                            <!-- Tombol Simpan -->
                            <button type="submit" class="btn btn-primary mr-2">Simpan</button>

                            <!-- Tombol Download -->
                            <a href="{{ route('bimbingan.exportPdf', Crypt::encrypt($bimbingan->id)) }}" class="btn btn-success">Download File</a>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format hasil bimbingan saat halaman dimuat
    formatHasilBimbingan();
    
    // Tambahkan event listener untuk memformat hasil bimbingan saat diubah
    document.getElementById('hasil_bimbingan').addEventListener('input', formatHasilBimbingan);
    
    function formatHasilBimbingan() {
        const textarea = document.getElementById('hasil_bimbingan');
        
        // Simpan posisi kursor
        const cursorPosition = textarea.selectionStart;
        
        // Dapatkan teks dari textarea
        let text = textarea.value;
        
        // Jika teks tidak kosong, pastikan setiap baris baru dimulai dengan nomor yang benar
        if (text.trim()) {
            // Pisahkan teks menjadi baris-baris
            let lines = text.split('\n');
            
            // Format setiap baris
            for (let i = 0; i < lines.length; i++) {
                // Hapus nomor yang ada di awal baris (jika ada)
                lines[i] = lines[i].replace(/^\d+\.\s*/, '').trim();
                
                // Tambahkan nomor baru jika baris tidak kosong
                if (lines[i]) {
                    lines[i] = (i + 1) + '. ' + lines[i];
                }
            }
            
            // Gabungkan kembali baris-baris
            text = lines.join('\n');
            
            // Perbarui nilai textarea
            textarea.value = text;
            
            // Kembalikan posisi kursor
            textarea.setSelectionRange(cursorPosition, cursorPosition);
        }
    }
});
</script>
@endsection
