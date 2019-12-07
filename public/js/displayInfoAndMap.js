mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jha25pc3RpYyIsImEiOiJjazF4eTY2NmYwZzZ2M21xZ2NqNW81aWp0In0.fbP9E6XJtuUbsNvh5eHjkw';
var map = mapboxSdk({ accessToken: mapboxgl.accessToken});
var lieu = jQuery('#map_product').attr('data-lieu');

lieu = lieu+',"France"';
map.geocoding.forwardGeocode({
    query: lieu,
    autocomplete: false,
    limit: 1
})
    .send()
    .then(function (response) {
        if (response && response.body && response.body.features && response.body.features.length) {
            var feature = response.body.features[0];

            var map = new mapboxgl.Map({
                container: 'map_product',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: feature.center,
                zoom: 10
            });
            new mapboxgl.Marker()
                .setLngLat(feature.center)
                .addTo(map);
        }
        map.addControl(new MapboxGeocoder({
            marker: {color: 'orange'},
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        }));
        // Add geolocate control to the map.
        map.addControl(new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        }));
        // Add zoom and rotation controls to the map.
        map.addControl(new mapboxgl.NavigationControl());
    });
var name = jQuery('#revealbutton').attr('data-phone');

var revealbutton= document.getElementById("revealbutton");
revealbutton.onclick = function() {
    revealbutton.innerText=name;
};