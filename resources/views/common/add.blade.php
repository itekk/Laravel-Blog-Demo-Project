@extends('layouts.'.Auth::user()->user_type)
@section('title', 'Create blog')

@section('content')
<div class="alert alert-primary" role="alert">
  {{ Breadcrumbs::render('create-blogs', Auth::user()->user_type) }}
</div>

<div class="custom-container">
  <h5>Create New Blog</h5>
  <form class="col-5 pt-2" method='post' action="{{ route('create-blog', Auth::user()->user_type) }}">
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
      <label>Blog Name <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="title" placeholder="Blog Name" required>
    </div>

    <div class="form-group mt-2">
      <label>Description <span class="text-danger">*</span></label>
      <textarea name="description" rows="5" cols="40" class="form-control tinymce-editor"></textarea>
    </div>
    
    <div class="form-group mt-3">
      <input type="submit" class="btn btn-primary" value="Save">
      @if (Auth::user()->user_type == 'admin')
        <a class="btn btn-secondary" href="{{ route('admin-blogs') }}">Cancel</a>
      @elseif (Auth::user()->user_type == 'supervisor')
        <a class="btn btn-secondary" href="{{ route('supervisor-blog-list') }}">Cancel</a>
      @else
        <a class="btn btn-secondary" href="{{ route('blogger-list') }}">Cancel</a>
      @endif
    </div>
  </form>
</div>
@endsection