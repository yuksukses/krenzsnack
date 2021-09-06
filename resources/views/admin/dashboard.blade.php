@extends('layouts.master')
@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Total Kategori</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-cube fa-5x"></i></span>
                <h1 class="no-margins font-bold">{{ $kategori }}</h1>
                <br>
                <a href="{{ route('kategori.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Total Produk</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-cubes fa-5x"></i></span>
                <h1 class="no-margins font-bold">{{ $produk }}</h1>
                <br>
                <a href="{{ route('produk.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Total Member</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-vcard fa-5x"></i></span>
                <h1 class="no-margins font-bold">{{ $member }}</h1>
                <br>
                <a href="{{ route('member.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Total Supplier</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-truck fa-5x"></i></span>
                <h1 class="no-margins font-bold">{{ $supplier }}</h1>
                <br>
                <a href="{{ route('supplier.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Stock Tersedia</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-cube fa-5x"></i></span>
                <h1 class="no-margins font-bold">{{ $stock }} Pcs</h1>
                <br>
                <a href="{{ route('produk.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Pengeluaran</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-dollar fa-5x"></i></span>
                <h1 class="no-margins font-bold">Rp. {{ format_uang($pengeluaran) }},00</h1>
                <br>
                <a href="{{ route('pengeluaran.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Pemasukan</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-bank fa-5x"></i></span>
                <h1 class="no-margins font-bold">Rp. {{ format_uang($pemasukan) }},00</h1>
                
                <br>
                <a href="{{ route('pemasukan.index') }}">
                <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>

                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Total Pendapatan</h5>
            </div>
            <div class="ibox-content">
                <span class="pull-right"><i class="fa fa-money fa-5x"></i></span>
                <h1 class="no-margins font-bold">Rp. {{ format_uang($hasil) }},00</h1>
                <br>
                <a href="{{ route('laporan.index') }}">
                    <h5>Lihat <i class="fa fa-arrow-circle-right"></i></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d
                    {{ tanggal_indonesia($tanggal_akhir, false) }}
                </h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="lineChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {

        var lineData = {
        labels: {{ json_encode($data_tanggal) }},
        datasets: [
            {
                label: "Pendapatan",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: {{ json_encode($data_pendapatan) }}
            }
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx2 = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx2, {type: 'line', data: lineData, options:lineOptions});

});
</script>
@endpush