@extends('layouts.'.Auth::user()->user_type)
@section('title', 'Change Password')

@section('content')
  <div class="alert alert-primary" role="alert">
    {{ Breadcrumbs::render('change-password', Auth::user()->user_type) }}
  </div>

  <div class="custom-container">
  <h5>Change Password</h5>
  <form class="col-5 pt-2" method='post' action="{{ route('change-password', [Auth::user()->user_type]) }}">
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

    <div class="form-group mt-2">
      <label>New Password</label>
      <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>

    <div class="form-group mt-2">
      <label>Confirm Password</label>
      <input type="password" class="form-control" name="password_confirmation" placeholder="Password" required>
    </div>

    <div class="form-group mt-3">
      <input type="submit" class="btn btn-primary" value="Update">
      <a class="btn btn-secondary" href="{{ route(Auth::user()->user_type . '-dashboard') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection