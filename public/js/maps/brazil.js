var map;



function initMap() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: -13.2399455, lng: -49.43847656},
    });

    // Create a <script> tag and set the USGS URL as the source.
    var script = document.createElement('script');

    // This example uses a local copy of the GeoJSON stored at
    // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
    script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
    document.getElementsByTagName('head')[0].appendChild(script);

    map.data.setStyle(function(feature) {
        var magnitude = '5.5';
        //var magnitude = feature.getProperty('mag');
        return {
            icon: getCircle(magnitude)
        };
    });

}

function getCircle(magnitude) {
    return {
        path: google.maps.SymbolPath.CIRCLE,
        fillColor: 'red',
        fillOpacity: .2,
        scale: Math.pow(2, magnitude) / 2,
        strokeColor: 'white',
        strokeWeight: .5
    };
}

function eqfeed_callback(results) {
    map.data.addGeoJson(results);
}

/*
 {"type":"FeatureCollection",
 "features":
 [
{"type":"Feature",
    "properties":
        {"mag":5.4,"place":"48km SSE of Pondaguitan, Philippines","time":1348176066,"tz":480,"url":"http://earthquake.usgs.gov/earthquakes/eventpage/usc000csx3","felt":2,"cdi":3.4,"mmi":null,
        "alert":null,"status":"REVIEWED","tsunami":null,"sig":"449","net":"us","code":"c000csx3","ids":",usc000csx3,","sources":",us,","types":",
        dyfi,eq-location-map,general-link,geoserve,historical-moment-tensor-map,historical-seismicity-map,nearby-cities,origin,p-wave-travel-times,phase-data,scitech-link,
        tectonic-summary,"},
    "geometry":{"type":"Point","coordinates":[126.3832,5.9775,111.16]},"id":"usc000csx3"}
 */