@extends('layouts.auth')
@section('login')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

                        <img alt="image" class="logo-name" src="{{ url($setting->path_logo) }}" width="150" />

        </div>
        <br>
        <h3>Selamat Datang di Krenz Snack</h3>
        <p>Website Management Krenz Snack
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Masuk Untuk Melihat Detail Bisnis Krenz Snack.</p>
        <form class="m-t" role="form" action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group @error('email') has-error @enderror">
                <input type="email" name="email" class="form-control" placeholder="Email" required=""
                    value="{{ old('email') }}" autofocus>
                @error('email')
                <span class="help-block with-errors text-left">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
                @error('password')
                <span class="help-block with-errors text-left">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
        </form>
        <p class="m-t"> <small>Website Krenz Snack we app framework base on Bootstrap 3 &copy; 2021</small> </p>
    </div>
</div>
@endsection