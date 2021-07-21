@extends('layouts.supervisor')
@section('title', 'Bloggers List')

@section('content')
  <div class="custom-container">
    <h5>Bloggers List</h5>
    <table class="table table-striped table-bordered table-hover table-responsive">
      <thead class="bg-dark text-white">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th class="text-center">Number of Blogs</th>
          <th>Last Login</th>
        </tr>
      </thead>
      <tbody>
        @foreach($userList as $row)
        <tr>
          <td>{{ $row->getUser->first_name }}</td>
          <td>{{ $row->getUser->last_name }}</td>
          <td>{{ $row->getUser->email }}</td>
          <td class="text-center">{{ $row->getBlogs->count() }}</td>
          <td>
            @if ($row->last_login)
            {{ date("m-d-Y H:i:s", strtotime($row->getUser->last_login)) }}
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection