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
      <a class="navbar-brand fw-bold" href="/">EazyRent</a>
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
            <a class="nav-link" href="#whoUs">Who are we</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonials">Testimonials</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#ourPartners">Our partners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contactUs">Contact us</a>
          </li>
        </ul>
        @auth
        <div class="auth d-flex align-items-center dropdown">
          {{-- <img src="{{ asset('images/users/faceIdImages/'. Auth::user()->faceIdPath) }}" id="user-icon"
            alt="{{Auth::user()->username}}"> --}}
            @if(!is_null(Auth::user()->profilePath))
            <img src="{{ asset('images/users/profile/'.Auth::user()->username.'_profile.png') }}" alt=""  id="user-icon">
            @else
            <img src="{{ asset('images/download.png') }}" alt="" id="user-icon" >
            @endif
          <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ Auth::user()->username }}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item cs" href="{{ route('user.editProfile') }}">Profil</a></li>
            <li><a class="dropdown-item cs" href="{{ route('user.history') }}">Transaction history</a></li>
            <hr class="dropdown-divider">
            <li>
              <a class="dropdown-item danger" href="{{ route('user.logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Log out
              </a>
              <form action="{{ route('user.logout') }}" id="logout-form" method="post">@csrf</form>
            </li>
          </ul>

          <div class="dropdown-toggle  dropend" href="#" id="notificationsDropdown" style="position: relative" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <span  class="new-notification-count" id="new-notification-count"></span>
            <i class="fas fa-bell text-muted"></i>
          </div>
          <ul class="notis-menu dropdown-menu abs" id="notification-list" aria-labelledby="notificationsDropdown">
           {{-- <li><a href="" class="notification">wgrgwrhteheh</a></li> --}}
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
  @yield('script')
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    let navLinks = document.querySelectorAll('.nav-link')
    // console.log(navLinks)
    navLinks.forEach((el) => {
      // console.log(el)
      el.addEventListener('click', () => {
        navLinks.forEach((e) => e.classList.remove('active'))
        el.classList.add('active')
      })
    })
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    let list = document.querySelector('#notification-list')
    let newNotifCount = document.querySelector('#new-notification-count')
    let newNotifications = 0
    $.get(`http://localhost:8000/user/loadNotifications`,function(data){
      if(data.length===0){
        let x = document.createElement('li')
      x.innerText="You have no notifications"
      list.appendChild(x);
      }else{
        data.forEach((e)=>{
          let a = document.createElement('a')
          a.href=`http://localhost:8000/user/booking-details/${e.bookingID}`
          a.textContent = e.message
          a.classList.add('notification')
          if(e.type=="ACCEPTED"){
            a.classList.add('accepted')
          }
          if(e.type=="DECLINED"){
            a.classList.add('declined')
          }
          let li = document.createElement('li')
          li.appendChild(a)
          list.appendChild(li)

          if(e.read_at===null){
            newNotifications++;
          }
        })
      }

      if(newNotifications!=0){
        newNotifCount.innerText = newNotifications
      }
      })
  </script>
</body>
</html>
