mapboxgl.accessToken =
  "pk.eyJ1Ijoid2ViZGV2c2ltcGxpZmllZCIsImEiOiJja2d1c2x2djAwODE1MnltaGNzeHljcWN4In0.4u6YymF-wOIYpDoUTMcNOQ"

navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
  enableHighAccuracy: true
})

function successLocation(position) {
  setupMap([position.coords.longitude, position.coords.latitude])
}

function errorLocation() {
  setupMap([-2.24, 53.48])
}

function setupMap(center) {
  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: center,
    zoom: 15
  })

  const nav = new mapboxgl.NavigationControl()
  map.addControl(nav)

  var directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken
  })

  map.addControl(directions, "top-left")
}

// EVENTS
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
// function for Direction and Pointing of one Point-----------
const addMarker = () => {
const marker = new mapboxgl.Marker()
const minPopup = new mapboxgl.Popup({closeButton: false, closeOnClick: false})
minPopup.setHTML("")
marker.setPopup(minPopup)
marker.setLngLat([36.67981,22.10816])
marker.addTo(map)
marker.togglePopup();
}
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

map.on("load",addMarker)
$.getJSON("https://jsonip.com?callback=?", function (data) {
  var ip = data;
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     console.log(url); //
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
