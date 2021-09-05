@extends('layouts.master')
@section('title')
Kategori
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-outline btn-xs dim"><i
                class="fa fa-plus"></i>
            Tambah</button>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th width="5%">No</th>
                    <th>Kategori</th>
                    <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
            </table>
        </div>
    </div>
</div>
@includeIf('kategori.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('kategori.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
                {data: 'Action', searchable: false, sortable: false},
            ]
        });
        
        $('#modal-form').validator().on('submit', function (e){
            if (! e.preventDefault()){
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
            swal({
            title: "Berhasil!",
            text: "Data anda telah tersimpan",
            type: "success",
            confirmButtonColor: "#1ab394"
            },function () {
                $('#modal-form').modal('hide');
                table.ajax.reload();
                });
            }
        });
    });
    function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }
    function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
        })
        .fail((errors) => {
            alert('tidak dapat menampilkan data');
            return;
        });
    }
    function deleteData(url){
        swal({
            title: "Peringatan!",
            text: "Apakah anda yakin ingin menghapus kategori ini?",
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
        }).fail((errors) => {
        swal("Gagal!", "Kategori tidak dapat dihapus, karna terpakai dalam produk", "error");
            return;
        });
    });
    }
    
    
        
    
</script>
@endpush