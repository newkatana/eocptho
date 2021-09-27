<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
<style>
    #mapid { 
        height: 700px; 
    max-width:700px;
    }
    .info {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255,255,255,0.8);
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
    }
    .legend {
        line-height: 21px;
        color: #555;
    }
    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }
</style>

<div id="mapid"></div>


<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
<script>
    // initialize the map on the "map" div with a given center and zoom
    // var mapboxAccessToken = pk.eyJ1Ijoia2F0YW5hMDA4IiwiYSI6ImNrdDFydzByNDBkaWUybnIyMmV4YWxxbjIifQ.gIHPbitnyfdXnqR8Xp4SSw ;
    var mymap = L.map('mapid').setView([7.500558, 100.158158], 10);
    var statesData = <?php include 'ptho.php';?>

    var clpopup = L.popup()
    function onMapClick(e) {
        clpopup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(mymap);
    }
    // mymap.on('click', onMapClick);

    // var popup = L.popup()
    // .setLatLng([7.517704, 100.096436])
    // .setContent("I am a standalone popup.")
    // .openOn(mymap);

    function getColor(d) {
    return d >= 70 ? '#009933' :
           d >= 60  ? '#ccff33' :
           d >= 50  ? '#ffff00' :
           d >= 40  ? '#ff6600' :
           d >= 30  ? '#ff0000' :
           d > 0   ? '#b30000' :
                      '#ffffff';
   
        }
        

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.density),
                weight: 1,
                opacity: 1,
                color: 'white',
                dashArray: '',
                fillOpacity: 0.5
            };
        }

        L.geoJson(statesData, {style: style}).addTo(mymap);

//Adding Interaction
        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 3,
                color: '#666666',
                dashArray: '',
                fillOpacity: 0.7
            });

            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
            info.update(layer.feature.properties);
        }
        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }


        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                // click: zoomToFeature
            });
        }

        geojson = L.geoJson(statesData, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(mymap);

//Custom Info Control
        var info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };

        // method that we will use to update the control based on feature properties passed
        info.update = function (props) {
            this._div.innerHTML = '<h4>ความครอบคลุมวัคซีนเข็ม1</h4>' +  (props ?
                '<h6><b>' + props.name_th + '</b><br />' + 'จำนวนผู้ไดรับวัคซีนเข็ม 1 : ' + props.personcount + ' คน <br>คิดเป็น ' + props.density + ' %</h6>'
                : '');
        };

        info.addTo(mymap);


//Custom Legend Control
        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 20, 30, 40, 50, 60, 70,80],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(mymap);



L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/light-v9',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1Ijoia2F0YW5hMDA4IiwiYSI6ImNrdDFydzByNDBkaWUybnIyMmV4YWxxbjIifQ.gIHPbitnyfdXnqR8Xp4SSw'
}).addTo(mymap);
// L.geoJson(statesData).addTo(mymap);
</script>
