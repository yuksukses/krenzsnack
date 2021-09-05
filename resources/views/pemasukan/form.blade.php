<div class="modal inmodal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" class="form-horizontal" method="post">
            @csrf
            @method('post')
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-money modal-icon"></i>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-10">
                          <select name="id_deskripsi_pemasukan" id="id_deskripsi_pemasukan" class="form-control" required>
                                <option value="">Pilih Salah Satu</option>
                                @foreach ($deskripsi as $key=>$item)
                            <option value="{{$item->id_deskripsi_pemasukan}}">{{$item->kode_transaksi}} || {{$item->deskripsi_pemasukan}}</option>
                        @endforeach
                            </select><span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nominal" class="col-sm-2 control-label">Nominal</label>
                        <div class="col-sm-10">
                            <input type="number" name="nominal" id="nominal" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
