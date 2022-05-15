<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
  <title>Dashboard</title>
</head>
<body>
  {{-- <h1>hello {{Auth::guard('admin')->user()->name}} you are in dashboard</h1>
  <h1>your password is {{Auth::guard('admin')->user()->password}}</h1>
  <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> press here to log out</a>
  <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form> --}}
  <div class="row">
    <aside class="sidebar d-flex flex-column justify-content-between align-items-center col-3 align-self-start">
      <a href="" class="navbar-brand">Eazy Rent</a>
        <ul class=" nav flex-column align-items-center justify-content-center">
          <li class="nav-item">
            <a href="#" class="nav-link active">dashboard</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">joining requests</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">agencies list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">users list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">baned users</a>
          </li>
        </ul>
      <div class="dropdown">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="" alt="" width="15" height="15">
          <span>{{Auth::guard('admin')->user()->username}}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="#">profile</a></li>
          <li><a class="dropdown-item" href="#">history</a></li>
          <hr>
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
        </ul>
      </div>

    </aside>
    <div class="main col-9">
      <div class="container">
        here go the content
      </div>
    </div>
  </div>
  {{-- scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
