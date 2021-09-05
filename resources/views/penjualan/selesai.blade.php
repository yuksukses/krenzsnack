@extends('layouts.master')
@section('title')
Transaksi Penjualan
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <div class="alert alert-success">
                <i class="fa fa-check icon"> Data transaksi telah disimpan</i>
            </div>
        </div>
    </div>
    <div class="ibox-footer">
        <button onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')" class="btn btn-warning"><i
                class="fa fa-print"></i> Cetak Nota</button>
        <button onclick="notaBesar('{{ route('transaksi.nota_besar') }}', 'Nota PDF')" class="btn btn-success"><i
                class="fa fa-print"></i> Nota besar</button>
        <a href="{{ route('transaksi.baru') }}" class="btn btn-primary"><i class="fa fa-calculator"></i>
            Transaksi Baru</a>
    </div>
</div>
@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    function notaKecil(url, title){
        popupCenter(url, title, 625, 500);
    }
    function notaBesar(url, title){
        popupCenter(url, title, 900, 675);
    }
    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;
        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );
        if (window.focus) newWindow.focus();
    }
</script>
@endpush