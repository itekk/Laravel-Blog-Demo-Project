@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
  <div class="alert alert-primary" role="alert">
    {{ Breadcrumbs::render('edit-user') }}
  </div>

  <div class="custom-container">
    <h5>Edit User</h5>
    <form class="col-5 p-3" method='post' action="{{ route('update-user', $userDet->id) }}">
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
        <label>First Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="first_name" placeholder="First Name" required value="{{ $userDet->first_name }}">
      </div>

      <div class="form-group">
        <label>Last Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required value="{{ $userDet->last_name }}">
      </div>

      <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="email" placeholder="Email" required value="{{ $userDet->email }}">
      </div>

      <div class="form-group">
        <label>User Type <span class="text-danger">*</span></label>
        <select class="custom-select form-control margin" name="user_type">
          @foreach($userTypes as $type)
            <option
              value="{{ $type['key'] }}"
              {{ $type['key'] == $userDet->user_type ? 'selected' : ''}}
            >
              {{ ucfirst($type['value']) }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="form-group mt-3">
        <input type="submit" class="btn btn-primary" value="Update">
        <a class="btn btn-secondary" href="{{ route('admin-users') }}">Cancel</a>
      </div>
    </form>
  </div>
@endsection