<!DOCTYPE html>
<html>
<head>
    <title>Printout Kategori</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <h2>Detail Kategori</h2>
    <p><strong>Nama Kategori :</strong> {{ $kategori->nama }}</p>
    <p><strong>Kode Kategori :</strong> {{ $kategori->kode }}</p>

    <h3>Daftar Item</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori->masterItems as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier }}</td>
                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i:s') }}
    </div>
</body>
</html>