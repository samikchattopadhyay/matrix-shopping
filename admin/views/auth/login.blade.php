@extends('layouts.auth')

@section('content')
<div id="loginform">
    <div class="text-center p-t-20 p-b-20">
        <span class="db"><img src="{{ assets('images/logo.png') }}" alt="logo" /></span>
    </div>
	<!-- Form -->
    <form class="form-horizontal m-t-20" id="loginform" action="{{ url('auth.login') }}" method="post">
        <div class="row p-b-30">
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                    </div>
                    <input type="email" name="email" placeholder="Email" class="form-control form-control-lg" aria-label="Email" aria-describedby="email" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                    </div>
                    <input type="password" name="password" placeholder="Password"  class="form-control form-control-lg" aria-label="Password" aria-describedby="password" required>
                </div>
            </div>
        </div>
        <div class="row border-top border-secondary">
            <div class="col-12">
                <div class="form-group">
                    <div class="p-t-20">
                        <a class="btn btn-info" role="button" href="{{ url('auth.retrieve') }}"><i class="fa fa-lock m-r-5"></i> Lost password?</a>
                        <button class="btn btn-success float-right" type="submit" name="login">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

