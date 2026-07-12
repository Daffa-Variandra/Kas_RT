<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Kas - {{ $client->name ?? 'Smart RW' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .garis-kop {
            border-bottom: 3px solid #000;
            margin-top: 10px;
            margin-bottom: 2px;
        }
        .garis-tipis {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }
        .judul-laporan {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .signature {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 50px;
        }
        .signature-space {
            height: 80px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PENGURUS LINGKUNGAN</h1>
        <h1>{{ strtoupper($client->name ?? 'RUKUN WARGA') }}</h1>
        <p>{{ $client->address ?? 'Alamat Belum Diatur' }}</p>
        <div class="garis-kop"></div>
        <div class="garis-tipis"></div>
    </div>

    <div class="judul-laporan">
        Laporan Pemasukan Kas<br>
        <small style="font-weight: normal; text-transform: none;">
            @if($bulan && $tahun)
                Periode: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}
            @elseif($tahun)
                Tahun: {{ $tahun }}
            @else
                Semua Periode (Bulan Berjalan)
            @endif
        </small>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Warga Penyetor</th>
                <th width="25%">Jenis Iuran</th>
                <th class="text-right" width="30%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}</td>
                <td>
                    {{ $item->user->name }}
                </td>
                <td>{{ $item->contribution->nama_iuran }}</td>
                <td class="text-right">{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada transaksi pemasukan pada periode ini.</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PEMASUKAN</td>
                <td class="text-right">Rp {{ number_format($totalKas, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Bendahara {{ $client->name ?? '' }}</strong></p>
        <div class="signature-space"></div>
        <p style="text-decoration: underline;">{{ Auth::user()->name }}</p>
    </div>

</body>
</html>
