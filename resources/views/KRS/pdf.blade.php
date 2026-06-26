<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Rencana Studi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            text-align: center;
        }
        td.text-center {
            text-align: center;
        }
        .info {
            margin-bottom: 15px;
        }
        .footer-date {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Kartu Rencana Studi (KRS)</h2>
    <p class="subtitle">Sistem Informasi Akademik</p>

    @if($mahasiswaInfo)
    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 120px;">NPM</td>
                <td style="border: none;">: {{ $mahasiswaInfo->npm }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Nama</td>
                <td style="border: none;">: {{ $mahasiswaInfo->nama }}</td>
            </tr>
        </table>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                @if(!$mahasiswaInfo)
                <th width="12%">NPM</th>
                <th width="20%">Nama Mahasiswa</th>
                @endif
                <th width="12%">Kode MK</th>
                <th>Nama Matakuliah</th>
                <th width="10%">Kelas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataKrs as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                @if(!$mahasiswaInfo)
                <td>{{ $item->npm }}</td>
                <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                @endif
                <td>{{ $item->kode_matakuliah }}</td>
                <td>{{ $item->matakuliah->nama_matakuliah ?? '-' }}</td>
                <td class="text-center">{{ $item->kelas ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ $mahasiswaInfo ? 4 : 6 }}" class="text-center">Tidak ada data KRS</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer-date">Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
</body>
</html>