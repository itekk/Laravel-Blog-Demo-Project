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
          <td>{{ $row->first_name }}</td>
          <td>{{ $row->last_name }}</td>
          <td>{{ $row->email }}</td>
          <td class="text-center">{{ $row->numBlogs }}</td>
          <td>
            @if ($row->last_login)
            {{ date("m-d-Y H:i:s", strtotime($row->last_login)) }}
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection