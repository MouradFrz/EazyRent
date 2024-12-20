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
  <nav class="navbar sticky-top navbar-expand-lg navbar-light">
    <div class="container">
      <div class="d-flex align-items-center">
        @if((Illuminate\Support\Facades\Route::current()->getName() === 'user.home') ||
        (Illuminate\Support\Facades\Route::current()->getName() === 'guestHome'))
        <button id="navbar-toggler"class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="box-shadow: none;padding:.5rem;margin-right:.5rem;border:0;">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"><span>Eazy</span>Rent</a>
        @else
        <abbr title="back to home">
          <a class="navbar-brand" href="/"><span>Eazy</span>Rent</a>
        </abbr>
        @endif
      </div>
      @if((Illuminate\Support\Facades\Route::current()->getName() === 'user.home') ||
      (Illuminate\Support\Facades\Route::current()->getName() === 'guestHome'))
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#howToRent">How to Rent</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#whoUs">Who are we</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonials">Testimonials</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#ourPartners">Our Partners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contactUs">Contact Us</a>
          </li>
        </ul>
      </div>
      @endif
      @auth
      <div class="auth dropdown">
        @if(!is_null(Auth::user()->profilePath))
        <img src="{{ asset('images/users/profile/'.Auth::user()->username.'_profile.png') }}"
          alt="{{Auth::user()->username}}" id="user-icon">
        @else
        <img src="{{ asset('images/download.png') }}" alt="{{Auth::user()->username}}" id="user-icon">
        @endif
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          {{ Auth::user()->username }}
        </a>
        <ul class="dropdown-menu" id="user-dropdown" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="{{ route('user.editProfile') }}">Profil</a></li>
          <li><a class="dropdown-item" href="{{ route('user.history') }}">Transaction history</a></li>
          <hr class="dropdown-divider">
          <li>
            <a class="dropdown-item danger" href="{{ route('user.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              Log out
            </a>
            <form action="{{ route('user.logout') }}" id="logout-form" method="post">@csrf</form>
          </li>
        </ul>
        <a class="dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <span class="new-notification-count" id="new-notification-count"></span>
          <i class="fas fa-bell text-muted"></i>
        </a>
        <ul class="dropdown-menu" id="notification-list" aria-labelledby="notificationsDropdown">
          {{-- <li><a href="" class="notification">wgrgwrhteheh</a></li> --}}
        </ul>
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
  @auth
  @if (is_null(Auth::user()->email_verified_at) and (Illuminate\Support\Facades\Route::current()->getName() !== 'verification.notice'))
  <div class="m-0 email-alert">
    <div class="container">
      Your email is not verified, You have to verify your email before booking a vehicle
      <a href="{{ route('verification.notice') }}" class="link link-underline">Verify my email</a>
    </div>
  </div>
  @endif
  @endauth
  @yield('content')
  <footer id="contactUs" class="header section">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6">
          <h2 class="footer_header">EAZYRENT</h2>
          <p>
            EazyRent is a platform that makes renting your next vehicle a simple task in an easy, fast and
            secure way.
            <br>
            Our goal is to gather agencies from all around the nation in one place.
            <br>
            To give you the best options with the least effort.
          </p>
        </div>
        <div class="col-12 col-md-6">
          <h2 class="footer_header">contact</h2>
          <ul class="contact">
            <li>
              <i class="fa-solid fa-location-dot"></i>
              <span>address</span>Constantine, Constantine, Algerie
            </li>
            <li>
              <i class="fa-solid fa-phone"></i>
              <span>phone number</span><br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +213 (0) 555 55 55 55 <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +213 (0) 666 66 66 66 <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +213 (0) 777 77 77 77 <br>
            </li>
            <li>
              <i class="fa-solid fa-envelope"></i>
              <span>email</span>contact@eazyrent.com
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-end">
      <div class="container">
        <p>by <span>hacene barboucha, mourad yaou, oussama foura</span></p>
        <p>All rights reserved Copyright &copy; 2022</p>
      </div>
    </div>
  </footer>
  @yield('script')
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    let navLinks = document.querySelectorAll('.nav-link')
    let navbarCollapse = document.querySelector('.navbar-collapse')
    navLinks.forEach((el) => {
      el.addEventListener('click', () => {
        navLinks.forEach((e) => e.classList.remove('active'))
        navbarCollapse.classList.remove('show')
        el.classList.add('active')
      })
    })
    let navbar = document.querySelector('.navbar')

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
    integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    let list = document.querySelector('#notification-list')
    let newNotifCount = document.querySelector('#new-notification-count')
    let newNotifications = 0
    $.get(`http://localhost:8000/user/loadNotifications`,function(data){
      if(data.length===0){
        let li = document.createElement('li')
        let a = document.createElement('a')
        a.href=``
        a.textContent = 'you don\'t have notificaions!'
        a.classList.add('dropdown-item')
        a.classList.add('dropdown-item-disabled')
        li.appendChild(a)
        list.appendChild(li);
      }else{
        data.forEach((e)=>{
          let a = document.createElement('a')
          a.href=`http://localhost:8000/user/booking-details/${e.bookingID}`
          a.textContent = e.message
          a.classList.add('notification')
          a.classList.add('dropdown-item')
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
<script>
  const headers = document.querySelectorAll(".header");
const lines = document.querySelectorAll(".nav-link");
window.addEventListener("scroll", show);
const trig = window.innerHeight / 0.95;
show();

function show() {
	headers.forEach((e, i) => {
		const bot = e.getBoundingClientRect().bottom;
		if (bot < trig) {
			lines.forEach(h => {
				h.classList.remove("active");
			});
			lines[i].classList.add("active");
		}
	}
	)
}
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js" integrity="sha512-VEBjfxWUOyzl0bAwh4gdLEaQyDYPvLrZql3pw1ifgb6fhEvZl9iDDehwHZ+dsMzA0Jfww8Xt7COSZuJ/slxc4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js" integrity="sha512-v8B8T8l8JiiJRGomPd2k+bPS98RWBLGChFMJbK1hmHiDHYq0EjdQl20LyWeIs+MGRLTWBycJGEGAjKkEtd7w5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  gsap.from('footer',{duration:1,ease:"power1.inOut",y:100,opacity:0,scrollTrigger:{trigger:'footer'}});
</script> --}}
<script>
   const dropdowns = document.querySelectorAll('.dropdown-menu')
   const toggler = document.querySelector('#navbar-toggler')

   toggler.addEventListener('click',()=>{
    dropdowns.forEach((e)=>{
      e.classList.toggle('down')
    })
   })
</script>
</body>

</html>
