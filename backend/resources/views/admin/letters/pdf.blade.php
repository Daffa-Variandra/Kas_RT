<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 2cm; }
        .header { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 16pt; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 14pt; margin: 5px 0 0 0; text-transform: uppercase; }
        .header p { font-size: 10pt; margin: 5px 0 0 0; font-style: italic; }
        .content { margin-top: 20px; text-align: justify; }
        .title { text-align: center; margin-bottom: 20px; font-weight: bold; text-decoration: underline; font-size: 14pt; text-transform: uppercase;}
        .number { text-align: center; margin-top: -15px; margin-bottom: 30px; font-size: 11pt; }
        table { width: 100%; margin-left: 20px; margin-bottom: 20px; }
        td { vertical-align: top; padding: 3px 0; }
        .td-label { width: 180px; }
        .signature-area { margin-top: 50px; text-align: right; }
        .signature-area div { display: inline-block; text-align: center; width: 250px; }
        .signature-img { max-height: 80px; max-width: 150px; margin: 10px auto; display: block; }
        .signature-placeholder { height: 80px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PENGURUS RUKUN TETANGGA 005</h1>
        <h2>RUKUN WARGA 001</h2>
        <p>Kelurahan Sukamaju, Kecamatan Berdikari, Kota Nusantara</p>
        <p>Sekretariat: {{ $letter->client->address ?? 'Jl. Merdeka No. 1, Telp. 08123456789' }}</p>
    </div>

    <div class="title">
        {{ $letter->letter_type }}
    </div>
    <div class="number">
        Nomor: {{ $letter->reference_number }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Ketua {{ auth()->user()->client->name ?? 'Lingkungan' }}, menerangkan bahwa:</p>
        
        <table>
            <tr>
                <td class="td-label">Nama Lengkap</td>
                <td>: <strong>{{ $letter->user->name }}</strong></td>
            </tr>
            <tr>
                <td class="td-label">Nomor KK</td>
                <td>: {{ $letter->user->family->family_card_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Alamat</td>
                <td>: {{ $letter->user->family->address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Email / No. HP</td>
                <td>: {{ $letter->user->email }}</td>
            </tr>
        </table>

        <p>Adalah benar warga yang berdomisili di wilayah {{ auth()->user()->client->name ?? 'Lingkungan' }}.</p>
        <p>Surat pengantar ini dibuat untuk keperluan:</p>
        <p><strong><em>"{{ $letter->purpose }}"</em></strong></p>
        <p>Demikian surat pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature-area">
        <div>
            <p>Nusantara, {{ $letter->updated_at->format('d F Y') }}</p>
            <p>Ketua {{ auth()->user()->client->name ?? 'Lingkungan' }}</p>
            
            @if($letter->client && $letter->client->signature_path)
                <img src="{{ public_path('storage/' . $letter->client->signature_path) }}" class="signature-img" alt="Tanda Tangan">
            @else
                <div class="signature-placeholder"></div>
            @endif
            
            <p style="text-decoration: underline; font-weight: bold;">{{ auth()->user()->name ?? 'Ketua' }}</p>
        </div>
    </div>
</body>
</html>
