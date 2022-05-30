@extends('layouts.userLayout')
@section('head')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
@endsection
@section('content')
<div class="hero">
  <div class="container hero_content">
    <div class="search-panel">
      <h2>search a vehicle now!</h2>
      <form action="{{route('user.viewOffers')}}" method="POST">
        @csrf
        <div class="row">
          <div class="col">
            <label for="">Pick-up location :</label>
            <div id="pickUpLocation"></div>
            @error('pickUpLng')<span class="danger">{{$message}}</span>@enderror
            <div class="d-none">
              <input type="text" id="pickUpLng" name="pickUpLng" />
              <input type="text" id="pickUpLat" name="pickUpLat" />
            </div>
          </div>
          <div class="col">
            <label for="">Pick up at :</label>
            <input type="datetime-local" class="inputs" name="pickUpDate" min="{{now()}}" />
            @error('pickUpDate')<span class="danger">{{$message}}</span>@enderror
          </div>
          <div class="col">
            <label for="">Drop off at :</label>
            <input type="datetime-local" class="inputs" name="dropOffDate" min="{{now()}}" />
            @error('dropOffDate')<span class="danger">{{$message}}</span>@enderror
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-4">
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
          </div>
          <div class="col-12 col-md-4">
            <button type="submit" class="custom-btn custom-btn-dark">Search</button>
          </div>
        </div>
    </div>
  </div>
  </form>
</div>
</div>
</div>
<div class="why-us d-flex align-items-center justify-content-center flex-column" style="margin-bottom: 60px">
  <h1 style="margin-bottom: 40px">Why us ?</h1>
  <div class="cards-container d-flex align-items-center flex-wrap justify-content-center mb-5">
    <div class="card d-flex flex-column">
      <i class="bi bi-square-fill"></i>
      <h1>Lorem ipsum</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
        facilis magni blanditiis enim tempora quis.
      </p>
    </div>
    <div class="card d-flex flex-column">
      <i class="bi bi-square-fill"></i>
      <h1>Lorem ipsum</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
        facilis magni blanditiis enim tempora quis.
      </p>
    </div>
    <div class="card d-flex flex-column">
      <i class="bi bi-square-fill"></i>
      <h1>Lorem ipsum</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
        facilis magni blanditiis enim tempora quis.
      </p>
    </div>
  </div>
  <div id="carouselExampleIndicators" class="carousel slide w-100" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="wrapper d-flex justify-content-center align-items-center flex-column">
          <i class="bi bi-square-fill"></i>
          <h1>Lorem ipsum</h1>
          <p>Lorem ipsum dolor sit amet , adipisicing elit. Assumenda facilis magni blanditiis enim tempora quis.
          </p>
        </div>
      </div>
      <div class="carousel-item">
        <div class="wrapper d-flex justify-content-center align-items-center flex-column">
          <i class="bi bi-square-fill"></i>
          <h1>Lorem ipsum</h1>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda facilis magni blanditiis enim
            tempora quis.</p>
        </div>
      </div>
      <div class="carousel-item">
        <div class="wrapper d-flex justify-content-center align-items-center flex-column">
          <i class="bi bi-square-fill"></i>
          <h1>Lorem ipsum</h1>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda facilis magni blanditiis enim
            tempora quis.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>
<div class="our-partners">
  <h1 style="margin-bottom: 40px">Our partners</h1>
  <div class="logos d-flex justify-content-center align-items-center">
    <i class="bi bi-check-circle-fill"></i>
    <i class="bi bi-spotify"></i>
    <i class="bi bi-apple"></i>
    <i class="bi bi-star-fill"></i>
  </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
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
</script>
<script>
  const ACCES_TOKEN = 'pk.eyJ1IjoiaGFjZW5iYXJiIiwiYSI6ImNsM2JoajQyejA3Z3YzaXFxbWZrZnJjM2gifQ.qAJQWOvoq02yHZ-DlED--Q';
  mapboxgl.accessToken = ACCES_TOKEN;

  mapboxgl.setRTLTextPlugin(
    'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
    null,
    true // Lazy load the plugin
  );
  const pirckUpGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    types: 'country,region,place,postcode,locality,neighborhood',
    countries: 'dz',
    // enableGeolocation: true,
  });
  pirckUpGeocoder.addTo('#pickUpLocation');

  // Get the geocoder results container.
  const pickUpLng = document.getElementById('pickUpLng');
  const pickUpLat = document.getElementById('pickUpLat');

  // Add geocoder result to container.
  pirckUpGeocoder.on('result', (e) => {
    pickUpLng.value = e.result.center[0];
    pickUpLat.value = e.result.center[1];
      // dropOffLng.value = e.result.center[0];
      // dropOffLat.value = e.result.center[1];
  });

  // Clear results container when search is cleared.
  pirckUpGeocoder.on('clear', () => {
    pickUpLng.innerText = '';
    pickUpLat.innerText = '';
  });
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
  document.querySelector('[name="pickUpDate"]').valueAsDateTime = new Date()

</script>
@endsection
