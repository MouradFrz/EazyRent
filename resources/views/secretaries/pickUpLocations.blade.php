@extends('layouts.workerLayout')

@section('headTags')
<title>pick up locations</title>
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
{{-- MAP BOX --}}
<script src='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css' rel='stylesheet' />
{{-- gl direction --}}
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>


<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
@endsection
@section('content')
<script>
  let pickUpLocations = document.querySelector('#pickUpLocations')
  pickUpLocations.classList.add('active')
</script>
<div class="pick-up-locations" style="min-height: 80vh">
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
    <h2 class="title">pick up locations</h2>
    <div class="row gx-3 gy-3">
      @foreach($pickUpLocations as $pul)
      <div class="col-12 col-md-4 col-xxl-3">
        <div class="pul">
          <p><strong>address: </strong>{{ $pul -> address_address}}</p>
          <p><strong>added by: </strong>{{ $pul -> added_by}}</p>
        </div>
      </div>
      @endforeach
      <div class="col-12 col-md-4 col-xxl-3">
        <div class="add-pul">
          <div class="add-pul_media">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          @if($pickUpLocations == null)
          <p>you don't have a pick up location yet <br> click the button bellow to add one</p>
          @endif
          <button class="link link-underline" data-bs-toggle="modal" data-bs-target="#addPickUpLocation">
            add a pick up location
          </button>
          <div class="modal fade" id="addPickUpLocation" tabindex="-1" aria-labelledby="addPickUpLocationLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addPickUpLocationLabel">Add a pick up locatoin</h5>
                </div>
                <form action="{{ route('secretary.addPickUpLocation') }}" method="POST">
                  @csrf
                  <div class="modal-body">
                    <label for="address" class="form-label">address</label>
                    <input type="text" name="address_address" id="address_address" class="inputs"
                      placeholder="enter pick up location address">
                    <div></div>
                    <div id='map' class="m-auto" style='width: 400px; height: 300px;'></div>
                    <p id="info" class="exclamation mt-2">use the blue marker to ping the pick up location</p>
                    <div id="address" class="d-none">
                      <input type="text" name="address_longitude" id="addressLongitude">
                      <input type="text" name="address_latitude" id="addressLatitude">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="link link-secondary" data-dismiss="modal">Close</button>
                    <button class="link" type="submit">Confirm</button>
                </form>
              </div>
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
    // marker.color('#007aff')
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
      // document.getElementById('info').innerHTML = '';
      // document.getElementById('info').appendChild(location)
      // fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${location.lng},${location.lat}.json?types=place&access_token=${ACCES_TOKEN}`)
      // .then(response => response.json())
      // .then(data => info.appendChild(document.createTextNode(data.features[0].place_name)))
      // .then(data => document.getElementById('address_address').value = info.textContent);
      }
    );

  }

</script>

@endsection
