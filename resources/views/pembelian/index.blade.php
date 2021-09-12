@extends('layouts.master')
@section('title')
Daftar Pembelian
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <button onclick="addForm()" class="btn btn-success btn-xs"><i class="fa fa-plus"></i>
            Transaksi Baru</button>
        @empty(! session('id_pembelian'))
        <a href="{{ route('pembelian_detail.index') }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i>
            Transaksi Aktif</a>
        @endempty
       

    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-pembelian">
                <thead>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
            </table>
        </div>
    </div>
</div>
@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-pembelian').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'Action', searchable: false, sortable: false},
            ]
        });
        $('.table-supplier').DataTable();

        table1 = $('.table-detail').DataTable({
            processing: true,
            bsort: false,
            dom: 'brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        });
    });
    function addForm(){
        $('#modal-supplier').modal('show');

    }
    function showDetail(url){
        $('#modal-detail').modal('show');
        table1.ajax.url(url);
        table1.ajax.reload();

    }
    function deleteData(url){
        swal({
            title: "Peringatan!",
            text: "Apakah anda yakin ingin menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus",
            closeOnConfirm: false
        },
        function () {
        $.post(url, {
        '_token': $('[name=csrf-token]').attr('content'),
        '_method': 'delete'
        })
        .done((response) => {
        swal("Deleted!", "Data anda telah terhapus", "success");
        table.ajax.reload();
        });
        });
    }
</script>
@endpush