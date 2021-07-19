@extends('layouts.admin')
@section('title', 'Assign Supervisors')

@section('content')
  <div class="alert alert-primary" role="alert">
    {{ Breadcrumbs::render('assign-supervisor') }}
  </div>

  <div class="custom-container">
    <h5>Assign Supervisors to Bloggers</h5>
    <div class="form-group col-5">
      <label>Select a Supervisor <span class="text-danger">*</span></label>
      <select class="custom-select form-control margin" onchange="changeSupervisor(this)" name="supervisor" id="supervisor">
        <option value="">Select one</option>
        @foreach($supervisors as $row)
          <option value="{{ $row->id }}" {{ isset($_GET['id']) && $row->id == $_GET['id'] ? 'selected' : ''}}>
            {{ $row->first_name }} {{ $row->last_name }} ({{ $row->email }})
          </option>
        @endforeach
      </select>
    </div>

    @if (isset($_GET['id']))
      <form class="col-5 pt-4" method='post' action="{{ route('assign-supervisors') }}">
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

        <input type="hidden" value="{{ $_GET['id'] }}" name="supervisorId">

        @foreach($bloggerList as $row)
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" name="bloggerId[]" value="{{ $row->id }}" {{ in_array($row->id, $assignedBloggers) ? ' checked' : '' }}>
          <label class="custom-control-label">{{ $row->first_name }} {{ $row->last_name }} ({{ $row->email }})</label>
        </div>
        @endforeach

        <div class="form-group mt-3">
          <input type="submit" class="btn btn-primary" value="Save">
          <a class="btn btn-secondary" href="{{ route('admin-users') }}">Cancel</a>
        </div>
      </form>
    @endif
  </div>
@endsection

<script>
  function changeSupervisor(element){
    var id = element.value;
    if (id) {
      var url = window.location.origin + window.location.pathname + '?id=' + id;
      location.replace(url);
    } else {
      var url = window.location.origin + window.location.pathname;
      location.replace(url);
    }
  }
</script>