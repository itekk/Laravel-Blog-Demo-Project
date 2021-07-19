@extends('layouts.blank')
@section('title', 'Login')

@section('content')
  <div class="mt-5">
    <div class="login-container m-auto">
      <h4 class="mb-3">LOGIN</h4>
      <form method='post' action="{{ route('login') }}">
        {!! csrf_field() !!}

        @if ($errors->first())
        <div class="alert alert-danger" role="alert">
          {{ $errors->first() }}
        </div>
        @endif

        @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
          {{ Session::get('message') }}
        </div>
        @endif

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button class="btn btn-success rounded-0" type="button">
              <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            </button>
          </div>
          <input type="text" class="form-control" name="email" placeholder="Email" required>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button class="btn btn-success rounded-0" type="button">
              <i class="fa fa-key" aria-hidden="true"></i>
            </button>
          </div>
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>

        <div class="form-group my-3 text-center">
          <input type="submit" class="btn btn-primary" value="Login">
        </div>
      </form>
      Not Registered? <a href="{{ route('register') }}">Sign up.</a>
    </div>
  </div>
@endsection