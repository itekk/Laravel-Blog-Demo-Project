@extends('layouts.admin')
@section('title', 'Bloggers')

@section('content')
  <div class="alert alert-primary" role="alert">
    {{ Breadcrumbs::render('assigned-bloggers-list') }}
  </div>

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
          <td>{{ $row->last_login }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $userList->links() }}
  </div>
@endsection