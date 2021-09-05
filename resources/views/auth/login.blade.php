@extends('layouts.auth')
@section('login')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">IN+</h1>

        </div>
        <h3>Welcome to IN+</h3>
        <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Login in. To see it in action.</p>
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
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div>
</div>
@endsection