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
          <p>{{ $pul -> address_address}}</p>
          <p>{{ $pul -> address_longitude}}</p>
          <p>{{ $pul -> address_latitude}}</p>
          <p>{{ $pul -> added_by}}</p>
          <p>{{ $pul -> address_created_at}}</p>
        </div>
      @endforeach
      <div class="col card">
        <p>you don't have a pick up location yet <br> click the button bellow to add one</p>
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
              <div class="modal-body d-flex justify-content-center flex-colunn">
                <div id='map' style='width: 400px; height: 300px;'></div>
              </div>
              <div class="modal-footer d-flex justify-content-center flex-column">
                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> --}}
                <span id="info">use the blue marker to ping the pick up location</span>
                <form action="{{ route('secretary.addPickUpLocation') }}" method="POST">
                  @csrf
                  <div id="address" class="d-none">
                    <input type="text" name="address_address" id="address_address">
                    <input type="text" name="address_longitude" id="addressLongitude">
                    <input type="text" name="address_latitude" id="addressLatitude">
                  </div>
                  <button class="btn btn-primary" type="submit">add now!</button>
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
  mapboxgl.accessToken = ACCES_TOKEN;

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
    let address = document.getElementById('address')
    let addressLongitude = document.getElementById('addressLongitude')
    let addressLatitude = document.getElementById('addressLatitude')
    let info = document.getElementById('info')

    function markeAdrress() {
      console.log('call function')
      let location = marker.getLngLat();
      let place_name;
      document.getElementById('addressLongitude').value = location.lng
      document.getElementById('addressLatitude').value = location.lat
      document.getElementById('info').innerHTML = '';
      fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${location.lng},${location.lat}.json?types=place&access_token=${ACCES_TOKEN}`)
      .then(response => response.json())
      .then(data => info.appendChild(document.createTextNode(data.features[0].place_name)))
      .then(data => document.getElementById('address_address').value = info.textContent);
    }

    // marker.on('dragstart', markeAdrress())
    marker.on('dragend', () => {
      let location = marker.getLngLat();
      document.getElementById('addressLongitude').value = location.lng
      document.getElementById('addressLatitude').value = location.lat

      document.getElementById('info').innerHTML = '';
      fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${location.lng},${location.lat}.json?types=place&access_token=${ACCES_TOKEN}`)
      .then(response => response.json())
      .then(data => info.appendChild(document.createTextNode(data.features[0].place_name)))
      .then(data => document.getElementById('address_address').value = info.textContent);
      }
    );

  }

</script>
{{-- <script>
  mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN', null) }}';

  var map = new mapboxgl.Map({
    container: 'map',
    style: 'Style_URL'
  });

  navigator.geolocation.getCurrentPosition(successLocation,errorLocation,{
    enableHighAccuracy: true
  })

  function successLocation(position){
      console.log(position)
  }
  function errorLocation(){
  }

  function getReverseGeocodingData(lat, lng) {
      var latlng = new google.maps.LatLng(lat, lng);
      // This is making the Geocode request
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
          if (status !== google.maps.GeocoderStatus.OK) {
              alert(status);
          }
          // This is checking to see if the Geoeode Status is OK before proceeding
          if (status == google.maps.GeocoderStatus.OK) {
              console.log(results);
              var address = (results[0].formatted_address);
          }
      });
  }

  function onClick(event){
    document.getElementById('lat').value = event.latlng.lat;
    document.getElementById('lng').value = event.latlng.lng;
    var group = L.featureGroup();
    group.id = 'group';
    var p_base = L.circleMarker([event.latlng.lat ,event.latlng.lng], {
      color: '#fff',
      fillColor: '#6a97cb',
      fillOpacity: 1,
      weight: 1,
      radius: 6
    }).addTo(group);
    map.addLayer(group);
  }

  // function START for getting lng,lat of current mouse position----------------
  map.on('mousemove', (e) => {
  document.getElementById('info').innerHTML =
  // `e.point` is the x, y coordinates of the `mousemove` event
  // relative to the top-left corner of the map.
  JSON.stringify(e.point) +
  '<br />' +
  // `e.lngLat` is the longitude, latitude geographical position of the event.
  JSON.stringify(e.lngLat.wrap());
  });
  // function END for getting lng,lat of current mouse position------------------


  // function START for getting current location----------------
  map.addControl(new mapboxgl.NavigationControl());
  map.addControl(
  new mapboxgl.GeolocateControl({
  positionOption:{
  enableHighAccuracy:true
  },
  trackUserLocation:true
  }));
  // function END for getting current location------------------

  // function for Direction and Pointing of one Point-----------
  map.addControl(
  new MapboxDirections({
  accessToken: mapboxgl.accessToken
  }),
  'top-left'
  );
  const addMarker = () => {
  const marker = new mapboxgl.Marker()
  // const minPopup = new mapboxgl.Popup({closeButton: false, closeOnClick: false})
  minPopup.setHTML("")
  marker.setPopup(minPopup)
  marker.setLngLat([36.67981,22.10816])
  marker.addTo(map)
  marker.togglePopup();
  }
  map.on("load",addMarker)
  $.getJSON("https://jsonip.com?callback=?", function (data) {
    var ip = data;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       // console.log(url);
      $.ajax({
       url :  '{{URL::to('updateip')}}' + '/' + id,
        type: 'POST',
       data: {_token: CSRF_TOKEN,
         "ip": ip,
         "id": id
      },
         dataType: 'json',
           success: function(response){
        }
      });
  });
  // function for Direction and Pointing of one Point-----------

  function show_marker(Lng,Lat,date,In,Out,hname,hin,hout)
  {
   const marker = new mapboxgl.Marker({ "color": "#b40219" })
   // const minPopup = new mapboxgl.Popup({closeButton: false, closeOnClick: false})
   minPopup.setHTML("<strong><b>IN n OUT DATE:</b><br>"+date+"<br><b>IN n OUT TIME:</b><br>"+In+"-"+Out+"<br><b>HOTEL NAME:</b><br>"+hname+"<br><b>HOTEL IN n OUT:</b><br>"+hin+"-"+hout+"</strong>")
   // marker.setPopup(minPopup)
   marker.setLngLat([Lng,Lat])
   // marker.setRotation(45);
   marker.addTo(map)
  }

  const popup = new mapboxgl.Popup({ closeOnClick: false })
  .setLngLat([-96, 37.8])
  .setHTML('<h1>Hello World!</h1>')
  .addTo(map);

</script> --}}

@endsection
