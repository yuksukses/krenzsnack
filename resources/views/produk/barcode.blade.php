<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>
    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            @foreach ($dataProduk as $produk)
            <td>
                <p class="text-center">
                    <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG("$produk->id", 'C39') }}" alt="qrcode"
                        height="40" width="80">
                </p>
                <p class="text-center">
                    {{ $produk->nama_produk }}
                </p>
            </td>
            @if ($no++ % 5 == 0)
        </tr>
        <tr>
            @endif
            @endforeach
        </tr>
    </table>
</body>

</html>