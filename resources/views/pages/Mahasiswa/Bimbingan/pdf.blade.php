<!DOCTYPE html>
<html>
<head>
    <title>Kartu Bimbingan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid black;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .signature-section {
            margin-top: 30px;
            text-align: right;
        }
        .hasil-bimbingan {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Kartu Bimbingan</h2>
    </div>
    
    <div class="info-section">
        <div class="info-item"><strong>Kelompok:</strong> {{ $bimbingan->kelompok->nomor_kelompok }}</div>
        <div class="info-item"><strong>Pembimbing:</strong> {{ $bimbingan->nama }}</div>
        <div class="info-item"><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($bimbingan->updated_at)) }}</div>
        <div class="info-item"><strong>Topic:</strong> {{ $bimbingan->keperluan }}</div>
        <div class="info-item"><strong>Hasil Bimbingan:</strong></div>
        <div class="hasil-bimbingan">
            {{ $bimbingan->hasil_bimbingan ?? 'Belum ada hasil bimbingan' }}
        </div>
    </div>

    <h3>Anggota Kelompok:</h3>
    <table>
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
    
    <div class="signature-section">
        <p>Tanggal: {{ date('d-m-Y') }}</p>
        <p>Tanda Tangan Pembimbing</p>
        <br><br><br>
        <p>{{ $bimbingan->nama }}</p>
    </div>
</body>
</html>