var map;


var myLatLng = {lat: -22.9068467, lng: -43.1728965};
var myLatLng2 = {lat: -1.4557549, lng: -48.4901799};
/*

var citymap = {
    rio: {
        center: {lat: -22.9068467, lng: -43.1728965},
        population: 271485
    },
    belem: {
        center: {lat: -1.4557549, lng: -48.4901799},
        population: 840583
    },
    piaiu: {
        center: {lat: -7.7183401, lng: -42.7289236},
        population: 385779
    },
};
*/

function initMap() {
    // Create the map.
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: -13.2399455, lng: -49.43847656},
        mapTypeId: 'terrain'
    });
/*
    // Construct the circle for each value in citymap.
    // Note: We scale the area of the circle based on the population.
    for (var city in citymap) {
        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * 100
        });
    }*/
}

/*

function initMap() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: -13.2399455, lng: -49.43847656},
    });

    // Create a <script> tag and set the USGS URL as the source.
    var script = document.createElement('script');
/!*

    // This example uses a local copy of the GeoJSON stored at
    // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
    script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
    document.getElementsByTagName('head')[0].appendChild(script);
*!/

    map.data.setStyle(function(feature) {
        var magnitude = '5.5';
        //var magnitude = feature.getProperty('mag');
        return {
            icon: getCircle(magnitude)
        };
    });

    var myLatLng = {lat: -22.9068467, lng: -43.1728965};
    var myLatLng2 = {lat: -1.4557549, lng: -48.4901799};

    var marker = new google.maps.Marker({
        path: google.maps.SymbolPath.CIRCLE,
        position: myLatLng,
        map: map,
        title: 'Hello World!'
    });
    var marker = new google.maps.Marker({
        path: google.maps.SymbolPath.CIRCLE,
        position: myLatLng2,
        map: map,
        title: 'Hello World!'
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
*/
