@extends('layouts.admin')
@section('title', 'Supervisors')

@section('content')
  <div class="custom-container">
    <h5>Supervisors List</h5>
    <table class="table table-striped table-bordered table-hover table-responsive">
      <thead class="bg-dark text-white">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th class="text-center">Number of Blogs</th>
          <th class="text-center">Number of Bloggers</th>
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
          <td class="text-center">{{ $row->numBlogs }}</td>
          <td class="text-center">{{ $row->numBlogers }}</td>
          <td>
            @if ($row->last_login)
            {{ date("m-d-Y H:i:s", strtotime($row->last_login)) }}
            @endif
          </td>
          <td class="text-center">
            <a class="btn btn-primary btn-sm" href="{{ route('view-bloggers',  $row->id) }}">View Bloggers</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $userList->links() }}
  </div>
@endsection