@extends('layouts.blank')
@section('title', 'View blog')

@section('content')
  <div class="custom-container my-5">
    <h5>{{ $blog->title }}</h5>
    <div>
      {!! $blog->description !!}
    </div>
  </div>
@endsection