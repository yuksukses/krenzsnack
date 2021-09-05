<div class="modal inmodal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" class="form-horizontal" method="post">
            @csrf
            @method('post')
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-cubes modal-icon"></i>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_produk" class="col-sm-2 control-label">Produk</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori" class="col-sm-2 control-label">Kategori</label>
                        <div class="col-sm-10">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="merk" class="col-sm-2 control-label">Merk</label>
                        <div class="col-sm-10">
                            <input type="text" name="merk" id="merk" class="form-control" value="-" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli" class="col-sm-2 control-label">Harga Beli</label>
                        <div class="col-sm-10">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual" class="col-sm-2 control-label">Harga Jual</label>
                        <div class="col-sm-10">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="diskon" class="col-sm-2 control-label">Diskon</label>
                        <div class="col-sm-10">
                            <input type="number" name="diskon" id="diskon" value="0" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stok" class="col-sm-2 control-label">Stok</label>
                        <div class="col-sm-10">
                            <input type="number" name="stok" id="stok" class="form-control" value="0" readonly>
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