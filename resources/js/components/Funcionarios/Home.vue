<template>
  <div>
    <div id="map" class="min-w-max h-[40vh] md:w-[50vw] md:h-[80vh]"></div>
  </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import * as L from "leaflet";
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: "leaflet/dist/images/marker-icon-2x.png",
  iconUrl: "leaflet/dist/images/marker-icon.png",
  shadowUrl: "leaflet/dist/images/marker-shadow.png"
});
let map;
export default {
  mounted() {
    map = L.map("map", {
      scrollWheelZoom: true,
    });
    map.setView([-15.797076100943771, -47.87551860828078], 2);
    L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution:
        '&copy; OSM Mapnik <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);
    let markers = new L.LayerGroup()
    markers.addTo(map)

    navigator.geolocation.getCurrentPosition((position) => {
    let lat = position.coords.latitude;
    let long = position.coords.longitude;

    const newMarker = L.marker([lat, long])
    newMarker.addTo(markers)
    map.setView([lat, long], 18);

    /* latText.innerText = lat.toFixed(2);
    longText.innerText = long.toFixed(2); */
  });
  },
};
</script>
