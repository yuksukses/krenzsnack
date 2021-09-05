@extends('layouts.master')
@section('title')
Edit Profil
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <form action="{{ route('user.updateProfil') }}" method="post" class="form-profil" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="ibox-content">
                    <div class="form-group row">
                        <label for="name" class="col-lg-2 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control" id="name" value="{{ $profil->name }}"
                                required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto" class="col-lg-2 control-label">Foto</label>
                        <div class="col-lg-4">
                            <input type="file" name="foto" class="form-control" id="foto"
                                onchange="preview('.tampil-foto', this.files[0], 200)">
                            <span class="help-block with-errors"></span>
                            <div class="tampil-foto"><img src="{{ url($profil->foto ?? '') }}" width="200"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="old_password" class="col-lg-2 control-label">Password Lama</label>
                        <div class="col-lg-6">
                            <input type="password" name="old_password" class="form-control" id="old_password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password" class="form-control" id="password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-lg-2 control-label">Password Confirmation</label>
                        <div class="col-lg-6">
                            <input type="password" data-match="#password" name="password_confirmation"
                                class="form-control" id="password_confirmation">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="ibox-footer">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#old_password').on('keyup', function () {
            if($(this).val() != "")$('#password, #password_confirmation').attr('required', true);
            else $('#password, #password_confirmation').attr('required', false);
        });

        $('.form-profil').validator().on('submit', function (e){
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-profil').attr('action'),
                    type: $('.form-profil').attr('method'),
                    data: new FormData($('.form-profil')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    $('[name=name]').val(response.name);
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="200">`);
                    toastr.info('Pengaturan telah diubah','BERHASIL')
                })
                .fail(errors => {
                    if (errors.status == 422) {
                    swal("Perhatian!", "Password lama tidak sesuai", "error");
                    }else{
                    alert('error');
                    }
                    return;
                })
            }
        }) 
    });
</script>
@endpush