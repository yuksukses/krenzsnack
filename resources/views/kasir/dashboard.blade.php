@extends('layouts.master')
@section('title')
Dashboard
@endsection

@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center">
                <h1>Welcome</h1>
                <h2>{{ auth()->user()->name }}</h2>
                <br>
                <a href="{{ route('transaksi.baru') }}" class="btn btn-success">Transaksi</a>
                <br>
            </div>
        </div>
    </div>

</div>

@endsection