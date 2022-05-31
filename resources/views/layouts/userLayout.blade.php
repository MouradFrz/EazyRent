<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EasyRent</title>
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" defer>
  <link href="{{ asset('css/user/index.css') }}" rel="stylesheet">
  @yield('head')
</head>

<body>
  <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">EazyRent</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">best deals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">why us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">our partners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">contact us</a>
          </li>
        </ul>
        @auth
        <div class="auth d-flex align-items-center dropdown">
          <img src="{{ asset('images/users/faceIdImages/'. Auth::user()->faceIdPath) }}" id="user-icon"
            alt="{{Auth::user()->username}}">
          <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ Auth::user()->username }}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item cs" href="#">Edit profil</a></li>
            <li><a class="dropdown-item cs" href="{{ route('user.history') }}">Show transaction history</a></li>
            <hr class="dropdown-divider">
            <li>
              <a class="dropdown-item danger " href="{{ route('user.logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Log out
              </a>
              <form action="{{ route('user.logout') }}" id="logout-form" method="post">@csrf</form>
            </li>
          </ul>
        </div>
      </div>
      @endauth
      @guest
      <div class="auth d-flex align-items-center">
        <a href="{{ route('user.login') }}" class="custom-btn custom-btn-dark" id="log-in">Go to Account</a>
      </div>
      @endguest
    </div>
    </div>
  </nav>
  @yield('content')
  <footer>
    <div class="container-md d-flex">
      <a href="" class="nav-link">Terms and conditions</a>
      <a href="" class="nav-link">FAQ</a>
      <a href="" class="nav-link">Our Values</a>
      <a href="" class="nav-link">About us</a>
      <a href="" class="nav-link">Contact us</a>
    </div>
  </footer>
  @yield('script')
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
