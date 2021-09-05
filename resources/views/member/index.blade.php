@extends('layouts.master')
@section('title')
Member
@endsection

@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <button type="button" onclick="addForm('{{ route('member.store') }}')" class="btn btn-success btn-sm"><i
                class="fa fa-plus-square"></i>
            Tambah</button>
        <button type="button" onclick="cetakKartu('{{ route('member.cetak_kartu') }}')"
            class="btn btn-primary btn-sm"><i class="fa fa-vcard"></i>
            Cetak Kartu</button>
    </div>
    <div class="ibox-content">
        <form class="form-member" method="post">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th width="1%">
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th width="3%">No</th>
                        <th>Kode Member</th>
                        <th>Nama Member</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                    </thead>
                </table>
            </div>
        </form>
    </div>
</div>
@includeIf('member.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('member.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_member'},
                {data: 'nama'},
                {data: 'telepon'},
                {data: 'alamat'},
                {data: 'Action', searchable: false, sortable: false},
            ]
        });
        
        $('#modal-form').validator().on('submit', function (e){
            if (! e.preventDefault()){
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    toastr.success('Data member telah disimpan','BERHASIL')
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
        $('#modal-form .modal-title').text('Tambah Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }
    function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
        .done((response) => {
            $('#modal-form [name=nama]').val(response.nama);
            $('#modal-form [name=telepon]').val(response.telepon);
            $('#modal-form [name=alamat]').val(response.alamat);
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
            toastr.error('Member telah dihapus','PERHATIAN')
        })
        .fail((errors) => {
            alert('tidak dapat menghapus data');
            return;
        });
        }
    }
    function cetakKartu(url){
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        }else{
            $('.form-member').attr('action', url).attr('target', '_blank').submit();
        }
    }
</script>

@endpush