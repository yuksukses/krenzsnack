@extends('layouts.master')
@section('title')
Laporan Stok
@endsection
@push('css')
<link href="{{ asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="col-lg-12 m-sm">
    <label>Pilih Bulan</label>
    <form action="{{ route('produk.stok') }}" class="form-inline">
        <div class="form-group">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control input-sm" name="pilih_bulan" id="pilih_bulan"
                    value="{{ request('pilih_bulan') }}" />
            </div>
            <button class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Set</button>
        </div>
    </form>
</div>
<div class="col-lg-6">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Laporan Stok Masuk bulan {{ tanggal_indonesia($bulanSekarang, false) }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-produk" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <th width="1%">No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Barang Masuk</th>
                            <th>Total Stok</th>
                        </thead>
                        <tbody>
                            @foreach ($stokMasuk as $key => $item)
                            <tr>
                                <td width="1%">{{ $key+1 }}</td>
                                <td><span class="label label-success">{{ $item->kode_produk ?? '' }}</span></td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->harga_beli }}</td>
                                <td>{{ $item->stokMasuk }}</td>
                                <td>{{ $item->stok }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Laporan Stok Terjual bulan {{ tanggal_indonesia($bulanSekarang, false) }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-produk" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <th width="1%">No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Merk</th>
                            <th>Harga Jual</th>
                            <th>Barang Terjual</th>
                            <th>Total Stok</th>
                        </thead>
                        <tbody>
                            @foreach ($stokTerjual as $key => $item)
                            <tr>
                                <td width="1%">{{ $key+1 }}</td>
                                <td><span class="label label-success">{{ $item->kode_produk ?? '' }}</span></td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->harga_jual }}</td>
                                <td>{{ $item->stokTerjual }}</td>
                                <td>{{ $item->stok }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

<script>
    let table;

$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'excel', text:'<i class="fa fa-download"></i> Excel', title: 'Laporan'},
                {extend: 'print', text:'<i class="fa fa-print"></i> Print',
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }                             
            ],
    });
});
    $("#datepicker").datepicker( {
    format: "yyyy-mm",
    startView: "months", 
    minViewMode: "months"
});
</script>
@endpush