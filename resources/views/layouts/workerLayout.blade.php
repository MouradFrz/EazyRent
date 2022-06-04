<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  @yield('headTags')
</head>

<body>
  {{-- <h1>hello {{Auth::guard('admin')->user()->name}} you are in dashboard</h1>
  <h1>your password is {{Auth::guard('admin')->user()->password}}</h1>
  <a href="{{ route('admin.logout') }}"
    onclick="event.preventDefault();document.getElementById('logout-form').submit();"> press here to log out</a>
  <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form> --}}
  <div class="row m-0">
    <aside class="sidebar col-4 col-md-3 col-xl-2">
      <div class="navbar-brand d-flex flex-column align-items-center auth">
        <img src="{{ asset('images/download.png') }}" alt="">
        <p class="user-fullname auth username">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</p>
        <div class="placeholder"></div>
        <div class="show-on-hover">
          @if(Auth::guard('owner')->check())
          <ul>
            <li><a href="{{ route('owner.showProfile') }}">Edit profil</a></li>
          </ul>
          @endif
          @if(Auth::guard('admin')->check())
          <ul>
            <li><a href="">Edit profil</a></li>
            <li><a href="">Show transaction history</a></li>
          </ul>
          @endif
          @if(Auth::guard('secretary')->check())
          <ul>
            <li><a href="{{ route('secretary.showProfile') }}">Edit profil</a></li>
            <li><a href="{{ route('secretary.history') }}">Show transaction history</a></li>
          </ul>
          @endif
          @if(Auth::guard('garagist')->check())
          <ul>
            <li><a href="{{ route('garagist.showProfile') }}">Edit profil</a></li>
          </ul>
          @endif
        </div>
      </div>
      @if(Auth::guard('admin')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item active">
          <a href="{{ route('admin.dashboard') }}" class="nav-link ">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.joiningRequests') }}" class="nav-link ">Joining requests</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.getAgencies') }}" class="nav-link ">Agencies list</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.usersList') }}" class="nav-link ">Users list</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.loadBans') }}" class="nav-link ">Banned users</a>
        </li>
      </ul>
      @endif
      @if(Auth::guard('owner')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item active">
          <a href="{{ route('owner.home') }}" class="nav-link ">Agency statistics</a>
        </li>
        <li class="nav-item active">
          <a href="{{ route('owner.showReclamations') }}" class="nav-link ">View client complaints</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('owner.employeesList') }}" class="nav-link ">Employees management</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('owner.showBranches') }}" class="nav-link ">Branches management</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('owner.showGarages') }}" class="nav-link ">Garages management</a>
        </li>
      </ul>
      @endif
      @if(Auth::guard('garagist')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item active">
          <a href="{{ route('garagist.vehicles') }}" class="nav-link ">Vehicle management</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('garagist.getReservations') }}" class="nav-link ">On going reservations</a>
        </li>
      </ul>
      @endif
      @if(Auth::guard('secretary')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item active">
          <a href="#" class="nav-link ">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('secretary.getReservationRequests') }}" class="nav-link ">Reservation requests</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('secretary.showVehicules') }}" class="nav-link ">Vehicules management</a>
        </li>
        <li class="nav-item">
          <a href="{{route('secretary.getPickUpLocations')}}" class="nav-link ">Pick up locations</a>
        </li>
      </ul>
      @endif
      {{-- <div class="dropdown">
        <hr style="color:white">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img src="" alt="" width="15" height="15">
          <span>{{Auth::user()->username}}</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="#">profile</a></li>
          <li><a class="dropdown-item" href="#">history</a></li>
          <hr>
          @if(Auth::guard('admin')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('owner')->check())
          <li>
            <a class="dropdown-item" href="{{ route('owner.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('secretary')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if(Auth::guard('garagist')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif

      </div> --}}
      <hr>
      @if(Auth::guard('admin')->check())
      <a class="custom-btn" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>

      @endif
      @if(Auth::guard('owner')->check())

      <a class="custom-btn" href="{{ route('owner.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
      @if(Auth::guard('secretary')->check())
        <a class="custom-btn" href="{{ route('admin.logout') }}"
          onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
        <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
      @if(Auth::guard('garagist')->check())
      <a class="custom-btn" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
    </aside>
    <div class="main col-8 col-md-9 col-xl-10">
      <div class="navbar">
        <div class="container">
          <h1 class="navbar-brand">EAZYRENT</h1>
        </div>
      </div>
      @yield('content')
    </div>
  </div>
  {{-- scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
  @yield('scripts')
</body>

</html>
