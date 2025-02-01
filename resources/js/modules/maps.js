const initMap = () => {
  mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2VsaXRvb29vIiwiYSI6ImNtNm1hNG5vdDBmaGUya3NoZnRldnhqd3YifQ.CMI4nKvoE7I8H9Dal7IHyw';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/marcelitoooo/ck16ms7m51nlo1cmwnqrbjuyq?optimize=true',
    center: [7.5758553848282535,47.571665321801994],
    zoom: 13
  });
  map.addControl(new mapboxgl.NavigationControl());
  map.scrollZoom.disable();

  var geojson = {
    type: 'FeatureCollection',
    features: [{
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: [7.5758553848282535,47.571665321801994]
      },
      properties: {
        title: 'Wohnen in Basel | Hüningerstrasse 40',
        description: 'Basel'
      }
    }]
  };

  // add markers to map
  geojson.features.forEach(function(marker) {

  // create a HTML element for each feature
  var el = document.createElement('div');
  el.className = 'marker';

  // make a marker for each feature and add to the map
  new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
  });
};

const loadMapScript = () => {
  var script = document.createElement('script');
  script.src = 'https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.js';
  script.async = true;
  document.head.appendChild(script);

  script.onload = () => {
    const mapEl = document.getElementById('map');
    if (mapEl !== null) {
      initMap();
    }
  }
}

loadMapScript();



