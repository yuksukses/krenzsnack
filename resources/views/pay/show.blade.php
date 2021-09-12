@extends('layouts.app')
@section('title','Detail Transaksi - '.$data->nomor_transaksi)
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
            <p>Nomer Transaksi : {{$data->nomor_transaksi}}</p>
            <p>User : {{$data->user ? $data->user->name:'-'}}</p>
            <p>Jenis Transaksi : {{$data->jenis_transaksi}}</p>
            <p>Nominal : {{number_format($data->nominal)}}</p>
            <p>Voucher : {{$data->vocher}}</p>
            <p>Metode : {{$data->metode}}</p>
            <p>Status : {{$data->status_transaksi}}</p>
            <p>Bukti : <img src="{{asset('images/'.$data->bukti)}}" width="200px"> </p>
            <a href="{{url('transaksi')}}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection