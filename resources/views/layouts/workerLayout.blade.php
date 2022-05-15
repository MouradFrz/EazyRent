<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
  
  @yield('headTags')
</head>
<body>
  {{-- <h1>hello {{Auth::guard('admin')->user()->name}} you are in dashboard</h1>
  <h1>your password is {{Auth::guard('admin')->user()->password}}</h1>
  <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> press here to log out</a>
  <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form> --}}
  <div class="row">
    <aside class="sidebar d-flex flex-column justify-content-between align-items-center col-4 col-md-3 align-self-start">
      <div class="navbar-brand">
        <a href="">
          Eazy Rent
        </a>
      </div>
      @if(Auth::guard('admin')->check())
        <ul class="nav flex-column align-items-center justify-content-center">
          <li class="nav-item active">
            <a href="#" class="nav-link ">dashboard</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">joining requests</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">agencies list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">users list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">baned users</a>
          </li>
        </ul>
        @endif
        @if(Auth::guard('owner')->check())
        <ul class="nav flex-column align-items-center justify-content-center">
          <li class="nav-item active">
            <a href="#" class="nav-link ">owner</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">owner</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">owner</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">owner</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">owner</a>
          </li>
        </ul>
        @endif
        @if(Auth::guard('garagist')->check())
        <ul class="nav flex-column align-items-center justify-content-center">
          <li class="nav-item active">
            <a href="#" class="nav-link ">garagist</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">garagist</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">agencies list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">users list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">baned users</a>
          </li>
        </ul>
        @endif
        @if(Auth::guard('secretary')->check())
        <ul class="nav flex-column align-items-center justify-content-center">
          <li class="nav-item active">
            <a href="#" class="nav-link ">secretary</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">secretary</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">agencies list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">users list</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link ">baned users</a>
          </li>
        </ul>
        @endif
      <div class="dropdown">
        <hr style="color:white">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="" alt="" width="15" height="15">
          <span>{{Auth::user()->username}}</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="#">profile</a></li>
          <li><a class="dropdown-item" href="#">history</a></li>
          <hr>
          @if(Auth::guard('admin')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('owner')->check())
          <li>
            <a class="dropdown-item" href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('secretary')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('garagist')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
         
      </div>

    </aside>
    <div class="main col-8 col-md-9">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </div>
  {{-- scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
