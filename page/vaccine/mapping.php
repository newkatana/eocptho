<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
<style>
    #mapid { height: 500px; }
</style>

<div id="mapid"></div>


<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
  <script type="text/javascript" src="../map/thailand.json"></script>
<script>
    // initialize the map on the "map" div with a given center and zoom
    // var mapboxAccessToken = pk.eyJ1Ijoia2F0YW5hMDA4IiwiYSI6ImNrdDFydzByNDBkaWUybnIyMmV4YWxxbjIifQ.gIHPbitnyfdXnqR8Xp4SSw ;
    var mymap = L.map('mapid').setView([51.505, -0.09], 9);
     var statesData = thailand;

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/light-v9',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1Ijoia2F0YW5hMDA4IiwiYSI6ImNrdDFydzByNDBkaWUybnIyMmV4YWxxbjIifQ.gIHPbitnyfdXnqR8Xp4SSw'
}).addTo(mymap);
L.geoJson(thailand).addTo(mymap);
</script>
