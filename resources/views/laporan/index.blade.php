@extends('layouts.master')
@section('title')
Laporan Transaksi {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection
@push('css')
<link href="{{ asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <label>Pilih Bulan</label>
        <form action="{{ route('laporan.index') }}" class="form-inline">
            <div class="form-group">
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control datepicker" name="tanggal_awal" id="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                    <span class="input-group-addon">s/d</span>
                    <input type="text" class="input-sm form-control datepicker" name="tanggal_akhir" id="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>
                <button class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Set</button>
            </div>
        </form>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Penjualan</th>
                    <th>Pembelian</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Pendapatan</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@includeIf('laporan.form')
@endsection

@push('scripts')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            searching: false,
            dom: '<"html5buttons"B>',
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
            ajax: {
                url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'penjualan'},
                {data: 'pembelian'},
                {data: 'pemasukan'},
                {data: 'pengeluaran'},
                {data: 'pendapatan'},
            ],
            bSort: false,
            paginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>
@endpush
