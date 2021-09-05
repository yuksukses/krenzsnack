@extends('layouts.master')
@section('title')
User
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-outline btn-xs dim"><i
                class="fa fa-plus"></i>
            Tambah</button>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
            </table>
        </div>
    </div>
</div>
@includeIf('user.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('user.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'name'},
                {data: 'email'},
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
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', true);
    }
    function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', false);
        $.get(url)
        .done((response) => {
            $('#modal-form [name=name]').val(response.name);
            $('#modal-form [name=email]').val(response.email);
        })
        .fail((errors) => {
            alert('tidak dapat menampilkan data');
            return;
        });
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