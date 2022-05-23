@extends('layouts.workerLayout')

@section('headTags')
<title>secretary - pick up locations</title>
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">

{{-- MAP BOX --}}

<script src='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css' rel='stylesheet' />
{{-- gl direction --}}
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>

{{--
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" /> --}}

<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

@endsection
@section('content')
<div class="pick-up-locations">
  <div class="container">
    @if (Session::get('fail'))
    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
      <strong>{{ Session::get('fail') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @error('address_address')
    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    @enderror
    @if (Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show w-100 " role="alert">
      <strong>{{ Session::get('success') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row row-cols-3">
      {{-- {{isset($pickUpLocations) ? 'is set' : 'is not set'}} --}}
      @foreach($pickUpLocations as $pul)
      <div class="col card">
        <p><strong>address: </strong>{{ $pul -> address_address}}</p>
        <p><strong>added by: </strong>{{ $pul -> added_by}}</p>
      </div>
      @endforeach
      <div class="col card">
        @if($pickUpLocations == null)
        <p>you don't have a pick up location yet <br> click the button bellow to add one</p>
        @endif
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPickUpLocation">add pick up
          location</button>
        <div class="modal fade" id="addPickUpLocation" tabindex="-1" aria-labelledby="addPickUpLocationLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addPickUpLocationLabel">Add pick up locatoin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('secretary.addPickUpLocation') }}" method="POST">
                @csrf
              <div class="modal-body d-flex justify-content-center align-items-center flex-column">
                <label for="address">address</label>
                <input type="text" name="address_address" id="address_address"
                placeholder="enter pick up location address" class="mb-2" style="width:100%">
                <div id='map' style='width: 400px; height: 300px;'></div>
              </div>
              <div class="modal-footer d-flex justify-content-center flex-column">
                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> --}}
                <span id="info"><strong> use the blue marker to ping the pick up location</strong></span>
                  <div id="address" class="d-none">
                    <input type="text" name="address_longitude" id="addressLongitude">
                    <input type="text" name="address_latitude" id="addressLatitude">
                  </div>
                  <button class="btn btn-primary" type="submit">Add now!</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // DEFINE MAPBOX ACCES TOKEN
  const ACCES_TOKEN = '{{ env('MAPBOX_TOKEN', null) }}';
  mapboxgl.accessToken = 'pk.eyJ1IjoiaGFjZW5iYXJiIiwiYSI6ImNsM2MydnpjaTAzanYza2xqMDUxNG1lb2QifQ.I1K8PXTiv_B7uBKYXMlByA';

  // get current location
  navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
  enableHighAccuracy: true
  })
  function successLocation(position) {
    setupMap([position.coords.longitude, position.coords.latitude],9)
  }
  function errorLocation() {
    let constantine = [6.6390, 36.3570]
    setupMap(constantine,5)
  }
  // PLUGINS
  // RTL SUPPORT
  mapboxgl.setRTLTextPlugin(
    'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
    null,
    true // Lazy load the plugin
  );

  // MAP SETUP
  function setupMap(center, zoom) {
    // MAP INIT
    const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/streets-v11', // style URL
    center: center, // starting position [lng, lat]
    zoom: zoom, // starting zoom
    doubleClickZoom:false,
    });

    // MAP CONTROLLERS
    // NAVIGATION CONTROLS
    const nav = new mapboxgl.NavigationControl();
    map.addControl(nav,'bottom-left');

    // GEOCODER
    // const geocoder = new MapboxGeocoder({
    // accessToken: ACCES_TOKEN,
    // mapboxgl: mapboxgl,
    // countries: 'dz',
    // enableGeolocation: true,
    // });
    // map.addControl(geocoder,'top-left');
    // geocoder.on('result', () => {
    //   console.log(geocoder.getAddressInfo())
    // } )
    // geocoder.on('error', () => {
    //   console.log('geocoder operation failed!')
    // } )

    //GEOLOCATE
    // const geolocate = new mapboxgl.GeolocateControl({
    //   positionOption:{
    //   enableHighAccuracy:true
    //   },
    //   trackUserLocation:true,
    //   showUserHeading:true
    // });
    // map.addControl(geolocate,'top-right');

    // MARKER
    const marker = new mapboxgl.Marker(
      {
      draggable: true
    }).setLngLat(center)
      .addTo(map)
    marker.setPitchAlignment('map');
    map.on('dblclick',(e) => {
      marker.setLngLat(e.lngLat)
      markeAdrress()
    })

    function markeAdrress() {
      console.log('call function')
      let location = marker.getLngLat();
      let place_name;
      document.getElementById('addressLongitude').value = location.lng
      document.getElementById('addressLatitude').value = location.lat
      document.getElementById('info').innerHTML = '';
      document.getElementById('info').appendChild(document.createTextNode(location))
      // fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${location.lng},${location.lat}.json?types=place&access_token=${ACCES_TOKEN}`)
      // .then(response => response.json())
      // .then(data => info.appendChild(document.createTextNode(data.features[0].place_name)))
      // .then(data => document.getElementById('address_address').value = info.textContent);
    } 

    // marker.on('dragstart', markeAdrress())
    marker.on('dragend', () => {
      let location = marker.getLngLat();
      document.getElementById('addressLongitude').value = location.lng
      document.getElementById('addressLatitude').value = location.lat
      document.getElementById('info').innerHTML = '';
      document.getElementById('info').appendChild(document.createTextNode(location))
      // fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${location.lng},${location.lat}.json?types=place&access_token=${ACCES_TOKEN}`)
      // .then(response => response.json())
      // .then(data => info.appendChild(document.createTextNode(data.features[0].place_name)))
      // .then(data => document.getElementById('address_address').value = info.textContent);
      }
    );

  }

</script>

@endsection
