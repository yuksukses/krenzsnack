<div class="modal inmodal" id="modal-produk" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="fa fa-cubes modal-icon"></i>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-produk">
                            <thead>
                                <th width="2%">No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th width="5%"><i class="fa fa-cog"></i></th>
                            </thead>
                            <tbody>
                                @foreach ($produk as $key => $item)
                                <tr>
                                    <td width="2%">{{ $key+1 }}</td>
                                    <td><span class="label label-primary">{{ $item->kode_produk }}</span></td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>
                                        @if ($item->stok >= 1)
                                        {{ $item->stok }}
                                        @else
                                        <p class="text-danger">Stok Habis</p>
                                        @endif
                                    </td>
                                    <td>Rp. {{ format_uang($item->harga_jual) }}</td>
                                    <td>
                                        @if ($item->stok >= 1)
                                        <a onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->kode_produk }}')"
                                            class="btn btn-xs btn-success">Pilih <i class="fa fa-long-arrow-right">
                                            </i></a>
                                        @else
                                        <a href="#" class="btn btn-xs btn-danger">X</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>