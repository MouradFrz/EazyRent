@extends('layouts.userLayout')
@section('head')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
  @media screen and (min-width: 640px) {
    .mapboxgl-ctrl-geocoder {
      max-width: none !important;
    }
  }
</style>
@endsection
@section('content')
<div class="hero">
  <div class="container">
    <div class="row">
      <div class="hero_content header col-12 col-lg-6">
        <h1>search for a vehicle</h1>
        <div class="search-panel" id="search-form">
          <form action="{{route('user.viewOffers')}}" method="GET">
            <label for="" class="label">Pick-up location :</label>
            <div id="pickUpLocation"></div>
            @error('pickUpLng')<span class="danger">{{$message}}</span>@enderror
            <div class="d-none">
              <input type="text" id="pickUpLng" name="pickUpLng" />
              <input type="text" id="pickUpLat" name="pickUpLat" />
            </div>
            <label for="date" class="label">Select a date : </label>
            <input type="date" name="" class='inputs' id="mydate" placeholder="Select date" onchange="fillFields()">
            @error('dropOffDate')<span class="danger">{{$message}}</span>@enderror
            <div class="d-none">
              <input type="datetime-local" class="inputs" name="pickUpDate" id="pickUpDate" />
              <input type="datetime-local" class="inputs" name="dropOffDate" id="dropOffDate" />
              @error('pickUpDate')<span class="danger">{{$message}}</span>@enderror
            </div>
            <button type="submit" class="custom-btn custom-btn-dark mt-4"><i class="fa-solid fa-magnifying-glass"
                style="font-size: .95rem;margin-right:.75rem"></i>Search</button>
          </form>
        </div>
      </div>
      <div class="hero_media col-12 col-lg-6" id="heroMedia">
        <img src="{{asset('images/home-hero-car-3.png')}}" alt="car">
      </div>
    </div>
  </div>
</div>
<div id="howToRent" class="booking-progress header section">
  <div class="white-space"></div>
  <div class="container">
    <h2 class="section-header">how to rent a vehicle</h2>
    <div id="progress">
      {{-- <div id="progress-bar"></div> --}}
      <ul id="progress-num">
        <li class="step active" value="0">1</li>
        <li class="step" value="1">2</li>
        <li class="step" value="2">3</li>
        <li class="step" value="3">4</li>
        <li class="step" value="4">5</li>
      </ul>
    </div>
    <div class="progress_content">
      <div class="step_content active">
        <h4>search for a vehicle</h4>
      </div>
      <div class="step_content">
        <h4>choose an offer</h4>
      </div>
      <div class="step_content">
        <h4>book a vehicule</h4>
      </div>
      <div class="step_content">
        <h4>confirm you identity</h4>
      </div>
      <div class="step_content">
        <h4>drive your car!</h4>
      </div>
    </div>
  </div>
</div>
</div>
<div id="whoUs" class="who-us header section">
  <div class="white-space"></div>
  <div class="container">
    <h2 class="section-header">what is EAZYRENT ?</h2>
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center align-items-center" id="object">
          <object data="{{asset('images/who-us.svg')}}" width="250" height="250"></object>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <p><span>EazyRent</span> is a platform that makes renting your next vehicle a simple task in an easy, fast and
          secure way.
          <br><br>
          Our goal is to gather agencies from all around the nation in one place.
          <br><br>
          To give you <span>the best options with the least effort.</span>
        </p>
      </div>
    </div>
  </div>
  <div class="white-space"></div>
</div>
<div id="testimonials" class="testimonials header ">
  <div class="white-space"></div>
  <h2 class="section-header section">what people say about us ?</h2>
  <div id="carouselExampleIndicators" class="carousel slide w-100 section" data-bs-ride="carousel">
    <div class="container content">
      {{-- carousel indecators ma7boch ybano n7ithom --}}
      <div class="carousel-inner">
        <div class="carousel-item active">
          <blockquote>
            <i class="fa-solid fa-quote-left"></i>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas consequatur ut voluptatum inventore quis
            cumque ad atque omnis aut doloremque error, deleniti maxime distinctio velit? Delectus quae magni suscipit
            tempora?
            <i class="fa-solid fa-quote-right"></i>
          </blockquote>
          <h6>| elon musq |</h6>
          <p>CEO of Tesla</p>
        </div>
        <div class="carousel-item">
          <blockquote>
            <i class="fa-solid fa-quote-left"></i>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas consequatur ut voluptatum inventore quis
            cumque ad atque omnis aut doloremque error, deleniti maxime distinctio velit? Delectus quae magni suscipit
            tempora?
            <i class="fa-solid fa-quote-right"></i>
          </blockquote>
          <h6>| elon musq |</h6>
          <p>CEO of Tesla</p>
        </div>
        <div class="carousel-item">
          <blockquote>
            <i class="fa-solid fa-quote-left"></i>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas consequatur ut voluptatum inventore quis
            cumque ad atque omnis aut doloremque error, deleniti maxime distinctio velit? Delectus quae magni suscipit
            tempora?
            <i class="fa-solid fa-quote-right"></i>
          </blockquote>
          <h6>| elon musq |</h6>
          <p>CEO of Tesla</p>
        </div>
        <div class="carousel-item">
          <blockquote>
            <i class="fa-solid fa-quote-left"></i>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas consequatur ut voluptatum inventore quis
            cumque ad atque omnis aut doloremque error, deleniti maxime distinctio velit? Delectus quae magni suscipit
            tempora?
            <i class="fa-solid fa-quote-right"></i>
          </blockquote>
          <h6>| elon musq |</h6>
          <p>CEO of Tesla</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <i class="fa-solid fa-angle-left"></i>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <i class="fa-solid fa-angle-right"></i>
    </button>
  </div>
  <div class="white-space"></div>
</div>
<div id="ourPartners" class="our-partners header section">
  <div class="white-space"></div>
  <h2 class="section-header">Companies who trust us</h2>
  <div class="container">
    <div class="row brands">
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-aws"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-aviato"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-bandcamp"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-apper"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-blackberry"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-buffer"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-cc-visa"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-bots"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-aviato"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-app-store"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-airbnb"></i>
      </div>
      <div class="brand col-4 col-md-3 col-lg-2">
        <i class="fa-brands fa-adversal"></i>
      </div>
    </div>
    @guest
    <p class="cta">you have a renting cars agency ? <a class="link link-underline"
        href="{{route('owner.register')}}">Join us &#62; </a></p>
    @endguest
  </div>
  <div class="white-space"></div>
</div>
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js">
</script>
<script>
  let progressSteps = document.querySelectorAll('#progress-num>.step');
  let stepsContent = document.querySelectorAll('.progress_content>.step_content');
  progressSteps.forEach(step => {
    step.addEventListener('click', () => {
      progressSteps.forEach(el => el.classList.remove('active'));
      stepsContent.forEach(el => el.classList.remove('active'))
      step.classList.add('active');
      stepsContent[progressSteps[step.value].value].classList.add('active');
    })
  });
</script>
<script>
  function fillFields(){
    const pickUpDate = document.querySelector('#pickUpDate')
    const dropOffDate = document.querySelector('#dropOffDate')
    const myDate = document.querySelector('#mydate')
    const array = myDate.value.split(" to ")
    pickUpDate.value=""
    dropOffDate.value=""
    if(array.length==2){
      pickUpDate.value=array[0].replace(' ','T')
      dropOffDate.value=array[1].replace(' ','T')
    }
  }
</script>
<script>
  const ACCES_TOKEN = 'pk.eyJ1IjoiaGFjZW5iYXJiIiwiYSI6ImNsM2JoajQyejA3Z3YzaXFxbWZrZnJjM2gifQ.qAJQWOvoq02yHZ-DlED--Q';
  mapboxgl.accessToken = ACCES_TOKEN;

  mapboxgl.setRTLTextPlugin(
    'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
    null,
    true // Lazy load the plugin
  );
  const pickUpGecoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    types: 'country,region,place,postcode,locality,neighborhood',
    countries: 'dz',
    // enableGeolocation: true,
  });
  pickUpGecoder.addTo('#pickUpLocation');

  // Get the geocoder results container.
  const pickUpLng = document.getElementById('pickUpLng');
  const pickUpLat = document.getElementById('pickUpLat');

  // Add geocoder result to container.
  pickUpGecoder.on('result', (e) => {
    pickUpLng.value = e.result.center[0];
    pickUpLat.value = e.result.center[1];
      // dropOffLng.value = e.result.center[0];
      // dropOffLat.value = e.result.center[1];
  });

  // Clear results container when search is cleared.
  pickUpGecoder.on('clear', () => {
    pickUpLng.innerText = '';
    pickUpLat.innerText = '';
  });
  let mapboxInput = document.querySelector('.mapboxgl-ctrl-geocoder--input');
  mapboxInput.classList.add('inputs');
  // ----------------------------------------------
  // const dropOffGeocoder = new MapboxGeocoder({
  //   accessToken: mapboxgl.accessToken,
  //   types: 'country,region,place,postcode,locality,neighborhood',
  //   countries: 'dz',
  //   // enableGeolocation: true,
  // });
  // dropOffGeocoder.addTo('#dropOffLocation');

  // // Get the geocoder results container.
  // const dropOffLng = document.getElementById('dropOffLng');
  // const dropOffLat = document.getElementById('dropOffLat');

  // // Add geocoder result to container.
  // dropOffGeocoder.on('result', (e) => {
  //   dropOffLng.value = e.result.center[0];
  //   dropOffLat.value = e.result.center[1];
  // });

  // // Clear results container when search is cleared.
  // dropOffGeocoder.on('clear', () => {
  //   pickUpLng.innerText = '';
  //   pickUpLat.innerText = '';
  // });
  // document.querySelector('[name="pickUpDate"]').valueAsDateTime = new Date()

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"
  integrity="sha512-VEBjfxWUOyzl0bAwh4gdLEaQyDYPvLrZql3pw1ifgb6fhEvZl9iDDehwHZ+dsMzA0Jfww8Xt7COSZuJ/slxc4Q=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js"
  integrity="sha512-v8B8T8l8JiiJRGomPd2k+bPS98RWBLGChFMJbK1hmHiDHYq0EjdQl20LyWeIs+MGRLTWBycJGEGAjKkEtd7w5Q=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  // gsap.from("#search-form",{duration:1.5,y:100,opacity:0})
  const sections = document.querySelectorAll(".section");
  sections.forEach(e => {
    gsap.from(e,{duration:1.4,ease:"power4.inOut",y:100,opacity:0,scrollTrigger:{trigger:e}});
});
gsap.from('#object',{duration:1.4,ease:"power4.inOut",x:-400,opacity:0,scrollTrigger:{trigger:'#object'}});
gsap.from('#heroMedia',{duration:1.8,ease:"power4.inOut",x:400,opacity:0});
// gsap.from('#search-form',{duration:0.8,ease:"power4.inOut",y:-100,opacity:0,scrollTrigger:{trigger:'#search-form'}});
</script>
@endsection
