@extends('layouts.userLayout')
@section('head')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    @media screen and (min-width: 640px){
      .mapboxgl-ctrl-geocoder {
      max-width:none !important;
      }
    }
  </style>
@endsection
@section('content')
<div class="hero">
  <div class="container hero_content">
    <div class="search-panel">
      <h2>search a vehicle now!</h2>
      <form action="{{route('user.viewOffers')}}" method="GET">
        <div class="row">
          <div class="col-12 col-md-6">
            <label for="" class="label">Pick-up location :</label>
            <div id="pickUpLocation"></div>
            @error('pickUpLng')<span class="danger">{{$message}}</span>@enderror
            <div class="d-none">
              <input type="text" id="pickUpLng" name="pickUpLng" />
              <input type="text" id="pickUpLat" name="pickUpLat" />
            </div>
          </div>
          <div class="col-12 col-md-6">
            <label for="date" class="label">Select a date : </label>
            <input type="date" name="" class='inputs' id="mydate" placeholder="Select date" onchange="fillFields()">
            @error('dropOffDate')<span class="danger">{{$message}}</span>@enderror
          </div>
          <div class="col d-none">
            <input type="datetime-local" class="inputs" name="pickUpDate" id="pickUpDate" min="{{now()}}" />
            <input type="datetime-local" class="inputs"name="dropOffDate" id="dropOffDate" min="{{now()}}"  />
            @error('pickUpDate')<span class="danger">{{$message}}</span>@enderror
          </div>
        </div>
        {{-- <div class="row"> --}}
          {{-- <div class="col-12 col-md-4">
            <input type="checkbox" name="PermenentDriverLicence" checked />
            <span>Driver has a permanent Driver Licence</span>
          </div>
          <div class="col-12 col-md-4">
            <input type="checkbox" id="driverAgeCheckBox" onclick="toggleDriverAge()" name="minAge" />
            <span>Driver age is less than 25</span>
            <div id="driverAge">
              <label class="driverAge">Driver's age :</label>
              <input type="number" name="driverAge" driverAge" style="margin-left: 16px" min="18" max="25" value="25" />
            </div>
          </div> --}}
          <div class="d-flex justify-content-center">
            <button type="submit" class="custom-btn custom-btn-dark"><i class="fa-solid fa-magnifying-glass" style="font-size: .95rem;margin-right:.75rem"></i>Search</button>
          </div>
        {{-- </div> --}}
    </div>
  </div>
  </form>
</div>
<div id="howToRent"class="booking-progress">
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
    <div  class="progress_content">
      <div class="step_content active">
        <h4>search for a vehicle</h4>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
      <div class="step_content">
        <h4>choose an offer</h4>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
      <div class="step_content">
        <h4>book a vehicule</h4>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
      <div class="step_content">
        <h4>confirm you identity</h4>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
      <div class="step_content">
        <h4>drive your car!</h4>
        <p>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
    </div>
  </div>
</div>
</div>
<div id="whoUs" class="who-us">
  <div class="white-space"></div>
  <div class="container">
    <h2 class="section-header">what is EAZYRENT ?</h2>
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center align-items-center">
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
<div id="testimonials" class="testimonials">
  <div class="white-space"></div>
  <h2 class="section-header">what people say about us ?</h2>
  <div id="carouselExampleIndicators" class="carousel slide w-100" data-bs-ride="carousel">
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
<div id="ourPartners" class="our-partners">
  <div class="white-space"></div>
  <h2 class="section-header">companies who trus us</h2>
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
    <p class="cta">you have a renting cars agency ? <a class="link link-underline" href="{{route('owner.register')}}">Join us &#62; </a></p>
    @endguest
  </div>
  <div class="white-space"></div>
</div>
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js">
</script>
<script>
  let driverAge = document.getElementById('driverAge')
  let driverAgeCheckBox = document.getElementById('driverAgeCheckBox')
  driverAge.style.display = "none"
  function toggleDriverAge() {
    if(driverAge.style.display === "none") {
      driverAge.style.display = "block";
    }else{
      driverAge.style.display = "none";
    }
  }
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
@endsection
