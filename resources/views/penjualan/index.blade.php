@extends('layouts.master')
@section('title')
Daftar Penjualan
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-penjualan">
                <thead>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Member</th>
                    <th>Kasir</th>
                    <th>Status</th>
                    <th width="10%"><i class="fa fa-cog"></i> Aksi</th>

                </thead>
            </table>
        </div>
    </div>
</div>
@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {

        table = $('.table-penjualan').DataTable({
            processing: true,
            autoWidth: false,
            dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'excel', text:'<i class="fa fa-download"></i> Excel', title: 'Daftar Penjualan'},
                ],
            ajax: {
                url: '{{ route('penjualan.data') }}',

            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'member'},
                {data: 'kasir'},
                {data: 'status'},
                {data: 'Action', searchable: false, sortable: false},
            ]
        });

        table1 = $('.table-detail').DataTable({
            processing: true,
            bsort: false,
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        });
    });

    function showDetail(url){
        $('#modal-detail').modal('show');
        table1.ajax.url(url);
        table1.ajax.reload();

    }
    function deleteData(url){
        swal({
            title: "Peringatan!",
            text: "Apakah anda yakin?",
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
        swal("Deleted!", "Data berhasil terhapus", "success");
        table.ajax.reload();
        });
        });
    }

</script>
@endpush
