@extends('layouts.'.Auth::user()->user_type)
@section('title', 'Edit blog')

@section('content')
<div class="alert alert-primary" role="alert">
  {{ Breadcrumbs::render('edit-blogs', Auth::user()->user_type) }}
</div>

<div class="custom-container">
  <h5>Edit Blog</h5>
  <form class="col-5 pt-2" method='post' action="{{ route('update-blog', [Auth::user()->user_type, $blogDet->id]) }}">
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
      <label>Title <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="title" placeholder="Title" required value="{{ $blogDet->title }}">
    </div>

    <div class="form-group mt-2">
      <label>Description <span class="text-danger">*</span></label>
      <textarea name="description" rows="5" cols="40" class="form-control tinymce-editor">
        {{ $blogDet->description }}
      </textarea>
    </div>

    <div class="form-group mt-3">
      <input type="submit" class="btn btn-primary" value="Update">
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