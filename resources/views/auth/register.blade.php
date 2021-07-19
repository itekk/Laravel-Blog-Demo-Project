@extends('layouts.blank')
@section('title', 'Register')

@section('content')
<div class="mt-5">
  <div class="login-container m-auto">
    <h4 class="mb-3">REGISTER</h4>
    <form method='post' action="{{ route('register-new') }}">
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

      <div class="form-group">
        <label>First Name</label>
        <input type="text" class="form-control" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}">
      </div>

      <div class="form-group mt-2">
        <label>Last Name</label>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}">
      </div>

      <div class="form-group mt-2">
        <label>Email</label>
        <input type="text" class="form-control" name="email" placeholder="Email" required value="{{ old('email') }}">
      </div>

      <div class="form-group mt-2">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>

      <div class="form-group mt-2">
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="Password" required>
      </div>

      <div class="form-group my-3 text-center">
        <input type="submit" class="btn btn-primary" value="Register">
      </div>
    </form>
    Already have an account? <a href="{{ route('login') }}">Login.</a>
  </div>
</div>
@endsection