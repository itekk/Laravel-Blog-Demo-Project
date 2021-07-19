<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog - @yield('title')</title>
    
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/combine/npm/jquery@3.4.1,npm/popper.js@1,npm/bootstrap@4/dist/js/bootstrap.min.js,npm/select2"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
        });
      </script>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin-dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('admin/user-list') ? 'active' : '' }}" href="{{ route('admin-users') }}">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('admin/supervisor-list') ? 'active' : '' }}" href="{{ route('admin-supervisor') }}">Supervisors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('admin/blog-list') ? 'active' : '' }}" href="{{ route('admin-blogs') }}">Blogs</a>
            </li>
          </ul>

          <div class="d-flex">
            <ul class="nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="container pt-3">
      @yield('content')
    </div>
  </body>
</html>