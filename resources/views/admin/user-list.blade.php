@extends('layouts.admin')
@section('title', 'Users')

@section('content')
  <div class="custom-container">
    <div class="row">
      <div class="mb-3 col-md-7 col-sm-12">
        <a class="btn btn-primary" href="{{ route('add-user') }}">Add New</a>
        <a class="btn btn-success" href="{{ route('assign-supervisors') }}">Assign Supervisors</a>
        <a class="btn btn-info text-white" href="{{ route('assign-bloggers') }}">Assign Bloggers</a>
      </div>
      <div class="col-md-5 col-sm-12">
        <form method='get' action="{{ route('admin-users') }}" class="d-flex searchform">
          <select class="custom-select form-control margin" name="type">
            <option value="">Select one</option>
            @foreach($userTypes as $type)
              <option
                value="{{ $type['key'] }}"
                {{ isset($_GET['type']) && $type['key'] == $_GET['type'] ? 'selected' : ''}}
              >
                {{ ucfirst($type['value']) }}
              </option>
            @endforeach
          </select>
          <button class="btn btn-primary margin">Search</button>
          <a class="btn btn-primary" href="{{ route('admin-users') }}">Clear</a>
        </form>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive">
      <thead class="bg-dark text-white">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>User Type</th>
          <th class="text-center">Number of Blogs</th>
          <th>Last Login</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($userList as $row)
        <tr>
          <td>{{ $row->first_name }}</td>
          <td>{{ $row->last_name }}</td>
          <td>{{ $row->email }}</td>
          <td>{{ $row->user_type }}</td>
          <td class="text-center">{{ $row->getBlogs->count() }}</td>
          <td>
            @if ($row->last_login)
            {{ date("m-d-Y H:i:s", strtotime($row->last_login)) }}
            @endif
          </td>
          <td class="text-center">
            @if ($row->id != Auth::user()->id)
            <a class="btn btn-primary btn-sm" href="{{ route('edit-user',  $row->id) }}">Edit</a>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteBlog({{ $row->id }})">Delete</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $userList->links() }}
  </div>
@endsection

<script>
  function deleteBlog(id) {
    var btn = confirm("Are you sure!");
    if (btn == true) {
      var postUrl = "{{ url('admin/delete-user')  }}";
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "DELETE",
        url: postUrl + "/" + id,
        success:function(response) {
          alert('Success.')
          location.reload();
        },
        error: function(xhr, status, error) {
          alert('Something went wrong.')
        }
      });
    }
  }
</script>