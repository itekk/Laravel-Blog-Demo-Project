@extends('layouts.blogger')
@section('title', 'Dashboard')

@section('content')
  <div class="custom-container">
    <h5>Personal Details</h5>
    <table class="table table-striped table-bordered table-hover table-responsive">
      <thead class="bg-dark text-white">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th class="text-center">Number of Blogs</th>
          <th>Last Login</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $userDet->first_name }}</td>
          <td>{{ $userDet->last_name }}</td>
          <td>{{ $userDet->email }}</td>
          <td class="text-center">{{ $userDet->getBlogs->count() }}</td>
          <td>
            @if ($userDet->last_login)
            {{ date("m-d-Y H:i:s", strtotime($userDet->last_login)) }}
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Edit</button>
            <a class="btn btn-success btn-sm" href="{{ route('change-password', [Auth::user()->user_type]) }}">Change Password</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Personal Details</h5>
        </div>
        <div class="modal-body">
          <form method='post' action="#" id="personalForm">
            {!! csrf_field() !!}
            {{ $errors->first() }}
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="form-group">
              <label>First Name</label>
              <input type="text" class="form-control" name="first_name" placeholder="First Name" required value="{{ $userDet->first_name }}">
              <p class="text-danger" id="fname"></p>
            </div>
            <div class="form-group mt-2">
              <label>Last Name</label>
              <input type="text" class="form-control" name="last_name" placeholder="Last Name" required value="{{ $userDet->last_name }}">
              <p class="text-danger" id="lname"></p>
            </div>
            <div class="form-group mt-2">
              <label>Email</label>
              <input type="text" class="form-control" name="email" placeholder="Email" required value="{{ $userDet->email }}">
              <p class="text-danger" id="email"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveData()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<script type='text/javascript'>
  function saveData() {
    var formEl   = document.forms.personalForm;
    var formData = new FormData(formEl);
    var fname    = formData.get('first_name');
    var lname    = formData.get('last_name');
    var email    = formData.get('email');
    if (fname && lname && email) {
      var posturl = "{{ route('personal-detail-update', Auth::user()->user_type) }}";
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: posturl,
        data: {
          first_name: fname,
          last_name: lname,
          email: email,
        },
        success:function(response) {
          alert('Success.')
          location.reload();
        },
        error: function(xhr, status, error) {
          if (xhr.responseJSON.errors.email) {
            $("#email").html(xhr.responseJSON.errors.email[0]);
          }
          if (xhr.responseJSON.errors.first_name) {
            $("#fname").html(xhr.responseJSON.errors.first_name[0]);
          }
          if (xhr.responseJSON.errors.last_name) {
            $("#lname").html(xhr.responseJSON.errors.last_name[0]);
          }
        }
      });
    } else {
      if (!fname) {
        $("#fname").html("First Name is required.");
      }
      if (!lname) {
        $("#lname").html("Last Name is required.");
      } 
      if (!email) {
        $("#email").html("Email is required.");
      }
    }
  }
</script>
