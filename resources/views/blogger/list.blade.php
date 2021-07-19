@extends('layouts.blogger')
@section('title', 'List')

@section('content')
  <div class="custom-container">
    <div class="row">
      <div class="mb-3 col-md-7 col-sm-12">
        <a class="btn btn-primary" href="{{ route('add-blog', Auth::user()->user_type) }}">Add New</a>
      </div>
      <div class="col-md-5 col-sm-12">
        <form method='get' action="{{ route('blogger-list') }}" class="d-flex searchform">
          <input type="text" class="form-control margin" name="search" placeholder="Search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
          <button class="btn btn-primary margin">Search</button>
          <a class="btn btn-primary" href="{{ route('blogger-list') }}">Clear</a>
        </form>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive">
      <thead class="bg-dark text-white">
        <tr>
          <th>Title</th>
          <th class="w-15 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($blogs as $row)
          <tr>
            <td>{{ $row->title }}</td>
            <td class="text-center">
              <a class="btn btn-success btn-sm" data-fancybox data-type="iframe" href="{{ route('view-blog', [Auth::user()->user_type, $row->id]) }}">View</a>
              <a class="btn btn-primary btn-sm" href="{{ route('edit-blog', [Auth::user()->user_type, $row->id]) }}">Edit</a>
              <button type="button" class="btn btn-danger btn-sm" onclick="deleteBlog({{ $row->id }})">Delete</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $blogs->links() }}
  </div>
@endsection

<script>
  function deleteBlog(id) {
    var btn = confirm("Are you sure!");
    if (btn == true) {
      var postUrl = "{{ url(Auth::user()->user_type . '/delete-blog/')  }}";
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