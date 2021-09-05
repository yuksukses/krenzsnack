@extends('layouts.master')
@section('title')
Transaksi Penjualan
@endsection
@push('css')
<style>
    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
        font-style: italic;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>

@endpush

@section('content')
<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-content">
            <h2 class="m-b-md">{{ tanggal_indonesia($penjualan->created_at, false) }}</h2>
            <h5 class="text-navy">Nama Kasir :
                {{ strtoupper(auth()->user()->name) }}
            </h5>
            <div class="form-group row">
                <div class="col-lg-8">
                    <div class="input-group" onclick="tampilMember()">
                        <input type="text" class="form-control" id="nama" value="{{ $memberSelected->nama }}"
                            placeholder="Masukkan Member">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary"><i class="fa fa-chevron-right"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-content">
            <form class="form-produk">
                @csrf
                <div class="form-group">
                    <div class="input-group col-md-12" onclick=" tampilProduk()">
                        <input type="hidden" name="id_produk" id="id_produk">
                        <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                        <input type="text" class="form-control" name="kode_produk" id="kode_produk"
                            placeholder="Pilih Produk...">
                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" oninput="inputProduk()" class="form-control" id="inputBarcode"
                            placeholder="Scan Produk">
                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-content">
            <strong class="pull-right text-navy">No Transaksi :
                INV-{{ tambah_nol_didepan($penjualan->id_penjualan, 8) }}</strong>
            <br>
            <h4 class="bayar-kembali"></h4>
            <h2 class="text-navy tampil-bayar"></h2>
            <h6 class="tampil-terbilang"></h6>
        </div>
    </div>
</div>
<div class="col-lg-8">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="table-responsive m-t">
                <table class="table table-striped table-bordered table-hover table-penjualan">
                    <thead>
                        <th width="2%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="5%">Jumlah</th>
                        <th width="5%">diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 pull-right">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                    @csrf
                    <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                    <input type="hidden" name="total" id="total">
                    <input type="hidden" name="total_item" id="total_item">
                    <input type="hidden" name="bayar" id="bayar">
                    <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->nama }}">

                    <div class="form-group row">
                        <label for="totalrp" class="col-lg-3 control-label">Total</label>
                        <div class="col-lg-8">
                            <input type="text" id="totalrp" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="diskon" class="col-lg-3 control-label">Diskon</label>
                        <div class="col-lg-8">
                            <input type="number" name="diskon" id="diskon" class="form-control"
                                value="{{ ! empty($memberSelected->nama) ? $diskon : 0 }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bayar" class="col-lg-3 control-label">Bayar</label>
                        <div class="col-lg-8">
                            <input type="text" id="bayarrp" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="diterima" class="col-lg-3 control-label">Diterima</label>
                        <div class="col-lg-8">
                            <input type="number" id="diterima" name="diterima" class="form-control"
                                value="{{ $penjualan->diterima ?? 0 }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kembali" class="col-lg-3 control-label">Kembali</label>
                        <div class="col-lg-8">
                            <input type="text" id="kembali" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ibox-footer m-sm">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                        class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.member')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse mini-navbar');
        table = $('.table-penjualan').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'action', searchable: false, sortable: false},
            ],
            dom: 'brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function (){
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });
    table2 = $('.table-produk').DataTable();

    $(document).on('input', '.quantity', function(){
        let id = $(this).data('id');
        let jumlah= parseInt($(this).val());
        let stok = $(this).attr("data-stok");

        if (jumlah > stok) {
            $(this).val(0);
            swal("Peringatan!", "Jumlah tidak boleh lebih dari stok", "error");
            return;
        }
        if (jumlah < 1) {
            $(this).val(1);
            swal("Peringatan!", "Jumlah tidak boleh kurang dari 1", "error");
            return;
        }
        if (jumlah > 100000) {
            $(this).val(99999);
            swal("Peringatan!", "Jumlah tidak boleh lebih dari 100000", "error");
            return;
        }

        $.post(`{{ url('/transaksi') }}/${id}`, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'put',
            'jumlah': jumlah
        })
            .done(response => {
                $(this).on('mouseout', function () {
                table.ajax.reload();
                })
            })
            .fail(errors => {
                
            })
        });

        $(document).on('input', '#diskon', function() {
            if ($(this).val()=="") {
                $(this).val(0).select();
            }
            loadForm($(this).val());
        });

        $('#diterima').on('input', function() {
           if ($(this).val() == "") {
               $(this).val(0).select();
           } 
           loadForm($('#diskon').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.btn-simpan').on('click', function() {
            let diterima= parseInt($('#diterima').val());
            let bayar= parseInt($('#bayar').val());

            if (diterima < bayar) {
            swal("Peringatan!", "Uang yang diterima kurang", "error");
            return;
            }
            if (bayar == 0) {
            swal("Peringatan!", "Masukkan Transaksi", "error");
            return;
            }
            $('.form-penjualan').submit();

        });
    });
    function tampilProduk(){
        $('#modal-produk').modal('show');
    }
    function hideProduk(){
        $('#modal-produk').modal('hide');
    }
    function tampilMember(){
        $('#modal-member').modal('show');
    }

    function pilihMember(id, nama){
        $('#id_member').val(id);
        $('#nama').val(nama);
        $('#diskon').val('{{ $diskon }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideMember();
    }

    function hideMember(){
        $('#modal-member').modal('hide');
    }

    function tambahProduk(){
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
        .done(response => {
            $('#kode_produk').focus();
            table.ajax.reload();
        })
        .fail(errors => {
            alert('error');
            return;
        })
    }
    function tambahProdukdariBarcode(){
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
        .done(response => {
            table.ajax.reload();
            $('#inputBarcode').focus().val('');
        })
        .fail(errors => {
            alert('Barcode tidak valid');
            return;
        })
    }

    function pilihProduk(id, kode){
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }
    function inputProduk(){
        var input = document.getElementById("inputBarcode").value;
        document.getElementById("id_produk").value = input;
        tambahProdukdariBarcode();
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

    function loadForm(diskon = 0, diterima = 0){
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
            .done(response => {
                $('#totalrp').val('Rp '+response.totalrp);
                $('#bayarrp').val('Rp '+response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.bayar-kembali').text('Total Bayar');
                $('.tampil-bayar').text('Rp '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp '+ response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.bayar-kembali').text('Uang Kembali');
                    $('.tampil-bayar').text('Rp '+ response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('error');
                return;
            })
    }


    
</script>
@endpush