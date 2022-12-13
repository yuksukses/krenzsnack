@extends('layouts.master')
@section('title')
Produk
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <button type="button" onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-sm"><i
                class="fa fa-plus-square"></i>
            Tambah</button>
        <button type="button" onclick="deleteSelected('{{ route('produk.delete_selected') }}')"
            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
            Hapus</button>
        <button type="button" onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')"
            class="btn btn-warning btn-sm"><i class="fa fa-barcode"></i>
            Cetak Barcode</button>
    </div>
    <div class="ibox-content">
        <form class="form-produk" method="post">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th width="1%">
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th width="1%">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th width="5%">Diskon</th>
                        <th>Stok</th>
                        <th width="5%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </form>
    </div>
</div>
@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'excel', text:'<i class="fa fa-download"></i> Excel', title: 'Daftar Penjualan'},
                ],
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
                {data: 'Action', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e){
            if (! e.preventDefault()){
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    toastr.success('Data telah disimpan','BERHASIL')
                })
                .fail((errors) => {
                    alert('tidak dapat menyimpan data');
                    return;
                });
            }
        });
        $('[name=select_all]').on('click', function (){
            $(':checkbox').prop('checked', this.checked);
        });
    });
    function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }
    function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();
        $('#stok').attr('readonly', false);

        $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_produk]').val(response.nama_produk);
            $('#modal-form [name=id_kategori]').val(response.id_kategori);
            $('#modal-form [name=merk]').val(response.merk);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=harga_jual]').val(response.harga_jual);
            $('#modal-form [name=diskon]').val(response.diskon);
            $('#modal-form [name=stok]').val(response.stok);
        })
        .fail((errors) => {
            alert('tidak dapat menampilkan data');
            return;
        });
    }
    function deleteData(url){
        if (confirm('Yakin Ingin Hapus Data')) {
            $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
        })
        .done((response) => {
            table.ajax.reload();
            toastr.error('Data telah dihapus','PERHATIAN')
        })
        .fail((errors) => {
            alert('tidak dapat menghapus data');
            return;
        });
        }
    }
    function deleteSelected(url){
        if ($('input:checked').length > 1) {
            if (confirm('Yakin Ingin Hapus Data')) {
                $.post(url, $('.form-produk').serialize())
            .done((response) => {
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
        });
            }
        }else{
            alert('Pilih data yang akan dihapus');
            return;
        }
    }

    function cetakBarcode(url){
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        }else if ($('input:checked').length < 3){
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        }else{
            $('.form-produk').attr('action', url).attr('target', '_blank').submit();
        }
    }
</script>

@endpush
