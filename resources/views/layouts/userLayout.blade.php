<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EazyRent - Home</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EasyRent</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
    </head>
    <body>

        <nav>
            <div class="container d-flex justify-content-between align-items-center">
                @auth
                <div class="auth d-flex align-items-center" >
                  <img src="{{ asset('images/users/faceIdImages/'. Auth::user()->faceIdPath) }}" id="user-icon" alt="">
                    <h6 class="m-0 username " style="color:rgb(79, 79, 79)">
                        {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}  &#9660
                    </h6>
                    <div class="show-on-hover">
                      <ul>
                        <li><a href="">Edit profil</a></li>
                        <li><a href="">Show transaction history</a></li>
                        <li><a href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log out</a></li>
                        <form action="{{ route('user.logout') }}" id="logout-form" method="post">@csrf</form>
                      </ul>
                    </div>
                  </div> 
                @endauth
                @guest
                <div class="auth d-flex align-items-center" >
                    <a href="{{ route('user.register') }}" class="" id="sign-up">Register</a>
                    <a href="{{ route('user.login') }}" class="" id="log-in">LogIn</a>
                  </div>
                @endguest
              
               
              <div class="brand d-flex align-items-center">
                <img src="" alt="" />
                <h1 class="fw-bold">EazyRent</h1>
              </div>
              <div class="link-list">
                <ul class="d-flex justify-content-center">
                  <li>
                    <a class="link" href="/home">Search for a car</a>
                  </li>
                  <li>
                    <a class="link" href="/order-car">Why us?</a>
                  </li>
                  <li><a class="link" href="#">Testimonials</a></li>
                  <li><a class="link" href="#">Our partners</a></li>
                  <li><a class="link" href="#">Contact us</a></li>
                </ul>
              </div>
              <button class="btn-dropdown">
                <i class="bi bi-list"></i>
              </button>
            </div>
            <div class="dropdown">
              <div class="link-list">
                <ul class="container">
                  <li>
                    <a class="link" href="#">Search for a car</a>
                  </li>
                  <li><a class="link" href="#">Why us?</a></li>
                  <li><a class="link" href="#">Testimonials</a></li>
                  <li><a class="link" href="#">Our partners</a></li>
                  <li><a class="link" href="#">Contact us</a></li>
                </ul>
              </div>
            </div>
          </nav>
        <div>
        
            @yield('content')
        </div>
            
        
    
        <footer>
          @{{ message }}
            <div class="container-md d-flex">
              <a href="" class="nav-link">Terms and conditions</a>
              <a href="" class="nav-link">FAQ</a>
              <a href="" class="nav-link">Our Values</a>
              <a href="" class="nav-link">About us</a>
              <a href="" class="nav-link">Contact us</a>
            </div>
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            document.querySelector(".btn-dropdown").addEventListener('click',()=>{
                document.querySelector(".dropdown").classList.toggle('active')
            });
        </script>
       
    </body>
    
</html>
