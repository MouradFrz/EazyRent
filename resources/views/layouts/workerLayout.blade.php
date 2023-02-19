<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/worker/worker.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css"
    integrity="sha512-wzhF4/lKJ2Nc8mKHNzoFP4JZsnTcBOUUBT+lWPcs07mz6lK3NpMH1NKCKDMarjaw8gcYnSBNjjllN4kVbKedbw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
  <meta name="_token" content="{{ csrf_token() }}">
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
        @if (Auth::guard('owner')->check())
        @if (!is_null(Auth::user()->profilePath))
        <img src="{{ Auth::user()->profilePath }}" alt="">
        @else
        <img src="{{ asset('images/download.png') }}" alt="">
        @endif
        @endif
        @if (Auth::guard('secretary')->check())
        @if (!is_null(Auth::user()->profilePath))
        <img src="{{ Auth::user()->profilePath }}" alt="">
        @else
        <img src="{{ asset('images/download.png') }}" alt="">
        @endif
        @endif
        @if (Auth::guard('admin')->check())
        @if (!is_null(Auth::user()->profilePath))
        <img src="{{ asset('images/admin/profile/' . Auth::user()->username) . '_profile.png' }}" alt="">
        @else
        <img src="{{ asset('images/download.png') }}" alt="">
        @endif
        @endif
        @if (Auth::guard('garagist')->check())
        @if (!is_null(Auth::user()->profilePath))
        <img src="{{ Auth::user()->profilePath }}" alt="">
        @else
        <img src="{{ asset('images/download.png') }}" alt="">
        @endif
        @endif
        <p class="user-fullname auth username">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
        </p>
        <div class="placeholder"></div>
        <div class="show-on-hover">
          @if (Auth::guard('owner')->check())
          <ul>
            <li><a href="{{ route('owner.showProfile') }}">Edit profil</a></li>
          </ul>
          @endif
          @if (Auth::guard('admin')->check())

          @endif
          @if (Auth::guard('secretary')->check())
          <ul>
            <li><a href="{{ route('secretary.showProfile') }}">Edit profil</a></li>
            <li><a href="{{ route('secretary.history') }}">Show transaction history</a></li>
          </ul>
          @endif
          @if (Auth::guard('garagist')->check())
          <ul>
            <li><a href="{{ route('garagist.showProfile') }}">Edit profil</a></li>
          </ul>
          @endif
        </div>
      </div>
      @if (Auth::guard('admin')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        {{-- <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" id="dashboard" class="nav-link "><i
              class="fa-solid fa-gauge-high"></i>Dashboard</a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ route('admin.joiningRequests') }}" id="joiningRequests" class="nav-link">
            <i class="fa-regular fa-rectangle-list"></i>
            Joining requests
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.getAgencies') }}" id="agencies" class="nav-link ">
            <i class="fa-solid fa-warehouse"></i>
            Agencies
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.usersList') }}" id="users" class="nav-link ">
            <i class="fa-solid fa-users"></i>
            Users
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.loadBans') }}" id="bannedUsers" class="nav-link">
            <i class="fa-solid fa-ban"></i>
            Banned users
          </a>
        </li>
      </ul>
      @endif
      @if (Auth::guard('owner')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item">
          <a id="agencyStats" href="{{ route('owner.home') }}" class="nav-link"><i
              class="fa-solid fa-chart-line"></i>Agency statistics</a>
        </li>
        <li class="nav-item">
          <a id="employees" href="{{ route('owner.employeesList') }}" class="nav-link"><i
              class="fa-solid fa-users"></i>Employees</a>
        </li>
        <li class="nav-item">
          <a id="branches" href="{{ route('owner.showBranches') }}" class="nav-link"><i
              class="fa-solid fa-code-branch"></i>Branches</a>
        </li>
        <li class="nav-item">
          <a id="garages" href="{{ route('owner.showGarages') }}" class="nav-link"><i
              class="fa-solid fa-warehouse"></i>Garages</a>
        </li>
        <li class="nav-item active">
          <a id="clientComplaints" href="{{ route('owner.showReclamations') }}" class="nav-link"><i
              class="fa-solid fa-comment"></i>Client complaints</a>
        </li>
      </ul>
      @endif
      @if (Auth::guard('garagist')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        <li class="nav-item">
          <a href="{{ route('garagist.vehicles') }}" id="vehicles" class="nav-link"><i
              class="fa-solid fa-car-side"></i>Vehicles
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('garagist.getReservations') }}" id="bookings" class="nav-link "><i
              class="fa-solid fa-rectangle-list"></i>On going bookings</a>
        </li>
      </ul>
      @endif
      @if (Auth::guard('secretary')->check())
      <ul class="nav flex-column align-items-center justify-content-center">
        {{-- <li class="nav-item">
          <a href="/" id="dashboard" class="nav-link"><i class="fa-solid fa-gauge-high"></i>Dashboard</a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ route('secretary.getReservationRequests') }}" id="reservations" class="nav-link "><i
              class="fa-solid fa-rectangle-list"></i>Reservation Requests</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('secretary.showVehicules') }}" id="vehicles" class="nav-link "><i
              class="fa-solid fa-car-side"></i>Vehicles</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('secretary.addVehicule') }}" class="nav-link child" id="addVehicleNav">Add a Vechicle</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link child non-functional" id="vehiculeDetailsNav">Vehicule Details</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('secretary.getPickUpLocations') }}" id="pickUpLocations" class="nav-link"><i
              class="fa-solid fa-location-dot"></i>Pick up Locations</a>
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
          @if (Auth::guard('admin')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if (Auth::guard('owner')->check())
          <li>
            <a class="dropdown-item" href="{{ route('owner.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if (Auth::guard('secretary')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif
          @if (Auth::guard('garagist')->check())
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">log out</a>
            <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
          @endif

      </div> --}}
      <hr>
      @if (Auth::guard('admin')->check())
      <a class="custom-btn" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
      @if (Auth::guard('owner')->check())
      <a class="custom-btn" href="{{ route('owner.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
      @if (Auth::guard('secretary')->check())
      <a class="custom-btn" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
      @if (Auth::guard('garagist')->check())
      <a class="custom-btn" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
      @endif
    </aside>
    <div class="main col-8 col-md-9 col-xl-10">
      <div class="navbar navbar-dark sticky-top">
        <div class="container">
          <a class="navbar-brand" href="#">EazyRent</a>
        </div>
      </div>
      @yield('content')
      <footer>
        <div class="container">
          <p>by <span>hacene barboucha, mourad yaou, oussama foura</span></p>
          <p>All rights reserved Copyright &copy; 2022</p>
        </div>
      </footer>
    </div>
  </div>
  {{-- scripts --}}
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  @yield('scripts')
</body>

</html>
