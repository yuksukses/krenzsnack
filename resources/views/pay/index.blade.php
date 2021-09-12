@extends('layouts.app')
@section('title','Transaksi')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@yield('title')</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (auth()->user()->level == 'Admin')
            <div class="alert alert-danger" role="alert">
                <center>Harap Periksa Bukti Transfer Dengan Benar Sebelum Mengubah Status Transaksi !<br></center>
                <br>
            </div>
            @endif
            @if (auth()->user()->level == 'Member')
            <div class="alert alert-danger" role="alert">
                <center>TRANSFER WAJIB KE REKENING DIBAWAH INI
                    <br>REKENING BCA
                <br>60413-74541
            <br> A/n Septiyan Dwi Nugroho</center>

            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">
                Tambah Transaksi !
            </button>
            @endif
            <div class="table-responsive-sm">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No. Transaksi</th>
                            @if (auth()->user()->level == 'Admin')
                            <th scope="col">User</th>
                            @endif
                            <th scope="col">Jenis Transaksi</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Vocher</th>
                            <th scope="col">Metode</th>
                            <th scope="col">Bukti</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)

                            <tr>
                                <th scope="row">{{ $row->id }}</th>
                                <td>{{ $row->nomor_transaksi }} </td>
                                @if (auth()->user()->level == 'Admin')
                                <th>{{$row->user? $row->user->name:'-'}}</th>
                                @endif
                                <td>{{ $row->jenis_transaksi }}</td>
                                <td>{{ $row->nominal }}</td>
                                <td>{{ $row->vocher }} </td>
                                <td>{{ $row->metode }} </td>
                                <td align="center"> 
                                    @if ($row->bukti!='')
                                    <img src="{{asset('images/'.$row->bukti)}}" width="100px">
                                    @endif

                                </td>
                                <td>{!! $row->badge_status !!} </td>
                                <td width="18%">
                                    <a href="{{url('/transaksi/'.$row->id.'/show')}}" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i></a>
                                    @if ($row->status_transaksi == 'On Progress')
                                        @if ($row->metode == 'Transfer Bank')
                                        <button type="button" class="btn btn-warning btn-sm" data-transaksi-id="{{$row->id}}" id="send-bukti">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                        @endif
                                        @if ($row->metode != 'Transfer Bank' && $row->jenis_transaksi == 'Pembelian Vocher')
                                        <a href="./transaksi/bayar/{{$row->id}}" class="btn btn-success btn-sm" data-transaksi-id="{{$row->id}}" >
                                            <i class="fas fa-money-check-alt"></i>
                                        </a>
                                        @endif
                                    @endif

                                    @if (auth()->user()->level == 'Admin')
                                    <button type="button" class="btn btn-success btn-sm" data-status="{{$row->status_transaksi}}" data-vocher="{{$row->vocher}}" data-transaksi-id="{{$row->id}}" id="change-status">
                                        <i class="fas fa-pen-square"></i>
                                    </button>
                                    <a href="{{url('/transaksi/'.$row->id.'/destroy')}}" class="btn btn-sm btn-danger"><i class="fas fa-trash-restore-alt"></i></a>
                                    @endif



                            </td>
                            </tr>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
            @if (auth()->user()->level != 'Admin')
            <div class="alert alert-info" role="alert">
                <center>PERHATIAN !!! Setelah Anda Melakukan Transaksi Pembelian, Kode Vocher Akan Muncul di Dalam Histori Transaksi
                    Anda, Harap Upload Bukti Transfer di Tombol "Bukti Transfer" Yang Ada di Samping Kanan Transaksi.
                    </a>
            @endif
        </div>
    </div>
</div>
{{-- CREATE MODAL --}}
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Baru !</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi Jual / Beli</h3>
                    </div>
                    <!-- form start -->
                    <form method="POST" action="{{ url('/transaksi') }}">
                        <div class="card-body">

                                <div class="form-group">
                                    {{ csrf_field() }}
                                    <label for="exampleFormControlSelect1">Jenis Transaksi</label>
                                    <select name="jenis_transaksi" class="form-control" id="exampleFormControlSelect1">
                                        <option value="Penjualan Vocher">Penjualan Vocher</option>
                                        <option value="Pembelian Vocher">Pembelian Vocher</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Nominal</label>
                                    <input type="text" class="form-control" id="ExampleInputEmail" name="jumlah"
                                        placeholder="Masukan Nominal Vocher">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Nominal yg diterima</label>
                                    <input type="text" class="form-control" id="ExampleInputEmail" name="nominal"
                                        placeholder="jika jual = kurang 2%, jika beli = tambah 2%dari nominal" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail">Kode Vocher</label>
                                    <input name="vocher" class="form-control" id="exampleInputEmail"
                                        placeholder="Kode Vocher">
                                </div>
                                <?php 
                                    $users = DB::table('users')
                                    ->where('id',Auth::user()->id)
                                    ->first();
                                ?>
                                <div class="form-group" id="beli">
                                    <label for="exampleFormControlSelect1">Metode Pembayaran</label>
                                    <select class="form-control" name="metode1" >
                                        <option value="deposit">Saldo Deposit (Rp.<?=number_format($users->deposit,0,",",".")?>)</option>
                                        {{-- <option value="Transfer Bank">Transfer Bank</option> --}}
                                        <option value="bank_transfer">Midtrans - Virtual Account</option>
                                        <option value="gopay">Midtrans - Gopay</option>
                                    </select>

                                </div>
                                <div class="form-group" id="jual">
                                    <label for="exampleFormControlSelect1">Saldo dikirim ke-</label>
                                    <?php 
                                            $data_banks= DB::table('data_banks')
                                        ->where('user_id',Auth::user()->id)
                                        ->get();
                                        
                                    ?>
                                    <select class="form-control" name="metode2" >
                                        <option value="deposit">Masuk ke Saldo Deposit</option>
                                        <?php 
                                            foreach ($data_banks as $v) {
                                                ?>
                                                <option><?=$v->nama_bank?> - <?=$v->nomor_rekening." AN ".$v->atas_nama?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>

                                </div>
                        </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
{{-- UBAH STATUS --}}
<div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/transaksi/change-status') }}">
            {{ csrf_field() }}
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="transaksi_id" readonly>
                <div class="form-group">
                    <label>Status Transaksi</label>
                    <select name="status_transaksi" class="form-control" required="">
                        @foreach (App\Transaksi::list_status() as $row)
                        <option value="{{$row}}">{{$row}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- UPLOAD BUKTI --}}
<div class="modal fade" id="bukti-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/transaksi/send-bukti') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="transaksi_id" readonly>
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#beli').hide();
        function get_jenis_transaksi()
        {
            return $('select[name="jenis_transaksi"]').val();
        }

        function set_nominal()
        {

            let jumlah = $('input[name="jumlah"]').val() ? $('input[name="jumlah"]').val():0;
            let nominal = 0;
            console.log(jumlah)
            if(jumlah)
            {
                let value = parseInt(jumlah);
                let persen = value*0.02;
                if(get_jenis_transaksi() == 'Pembelian Vocher')
                {
                    nominal = value+persen;
                    $('#beli').show();
                    $('#jual').hide();
                }else{
                    nominal = value-persen;
                    $('#beli').hide();
                    $('#jual').show();
                }
            }

            $('input[name="nominal"]').val(nominal)
        }

        function set_vocher(state)
        {
            if(state == true)
            {
                $('input[name="vocher"]').attr('readonly','');
                $('input[name="vocher"]').val('');
            }else{
                $('input[name="vocher"]').val('');
                $('input[name="vocher"]').removeAttr('readonly');

            }
        }

        $(document).on('change','select[name="jenis_transaksi"]',function(){
            if(get_jenis_transaksi() == 'Pembelian Vocher')
            {
                // $('input[name="vocher"]').attr('readonly','')
                set_vocher(true);
                set_nominal()
                $('#beli').show();
                    $('#jual').hide();
            }else{
                set_vocher(false);
                // $('input[name="vocher"]').removeAttr('readonly')
                set_nominal()
                $('#beli').hide();
                    $('#jual').show();
            }
        });

        $(document).on('keyup focus','input[name="jumlah"]',function(){
            set_nominal();
        })



        $(document).on('click','#change-status',function(e){
            e.preventDefault();
            $('input[name="transaksi_id"]').val($(this).data('transaksi-id'));
            $('select[name="status_transaksi"]').val($(this).data('status'));
            $('#status-modal').modal('show');
        });

        $(document).on('click','#send-bukti',function(e){
            e.preventDefault();
            $('input[name="transaksi_id"]').val($(this).data('transaksi-id'));
            $('#bukti-modal').modal('show');
        });

        $(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
    })
</script>
@endpush
