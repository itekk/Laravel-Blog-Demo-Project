@extends('layouts.'.Auth::user()->user_type)
@section('title', 'No Permission')

@section('content')
<div class="custom-container">
  <h5>You have no permission to perform this action.</h5>
</div>
@endsection