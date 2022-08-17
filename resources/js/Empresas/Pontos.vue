<template>
    <div class="w-full h-full">
        Verificação de pontos
        <div class="p-5 flex flex-col md:flex-row">
            <div id="map" class="min-w-max h-[40vh] md:w-[50vw] md:h-[80vh]"></div>
            <div class="pl-5 flex-1">

                <div class="mb-4 w-full">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nomePonto">
                        Nome do ponto
                    </label>
                    <input v-model="nome"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nomePonto" type="text" placeholder="Nome do ponto">
                </div>
                <div>
                    <span>Tipo</span>
                    <div class="form-check">
                        <input
                            class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                            type="radio" name="TIPO" id="quadrilatero" checked>
                        <label class="form-check-label inline-block text-gray-800" for="quadrilatero">
                            Quadrilatero
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                            type="radio" name="TIPO" id="circulo">
                        <label class="form-check-label inline-block text-gray-800" for="circulo">
                            Circulo
                        </label>
                    </div>

                    <div class="flex-1" v-if="!desenhos">
                        <button type="button"
                            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full md:w-auto"
                            @click="aplicarForma">Aplicar</button>
                    </div>
                    <div class="flex flex-col w-full md:w-auto space-y-2">
                        <div class="flex-1 md:flex-auto" v-if="desenhos">
                            <button type="button"
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full md:w-auto"
                                @click="clearAll">Limpar</button>
                        </div>
                        <div class="flex-1 md:flex-auto" v-if="desenhos">
                            <button type="button"
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full md:w-auto"
                                @click="salvarPonto">Salvar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import * as L from 'leaflet'
import 'leaflet-geosearch/dist/geosearch.css';
import 'leaflet-path-transform';
import * as GeoSearch from 'leaflet-geosearch'
import axios from "axios";

let map
let markers
let desenhos

export default {
    data: () => {
        return {
            map: null,
            markers: null,
            desenhos: false,
            nome: null,

        }
    },
    methods: {
        aplicarForma() {
            if (markers.getLayers().length === 4) {
                const markersSelecionados = []
                for (let i of markers.getLayers()) {
                    markersSelecionados.push(i.getLatLng())
                }
                let r = L.rectangle(markersSelecionados, { transform: true, draggable: true }).addTo(desenhos)
                r.dragging.enable();
                this.desenhos = true;
                //r.transform.enable();
                r.transform.enable({ rotation: true, uniformScaling: false });

                markers.clearLayers()
            }
        },
        deg2rad: deg => (deg * Math.PI) / 180.0,

        distancia(lat1, lon1, lat2, lon2) {

            const dlat = ((lat1 - lat2) * Math.PI) / 180.0
            const dlng = ((lon1 - lon2) * Math.PI) / 180.0

            lat1 = deg2rad(lat1);
            lat2 = deg2rad(lat2);
            lon1 = deg2rad(lon1);
            lon2 = deg2rad(lon2);

            let a = Math.pow(Math.sin(dlat / 2), 2) + Math.pow(Math.sin(dlng / 2), 2) * Math.cos(lat1) * Math.cos(lat2)
            const dist = 6371 * (2 * Math.asin(Math.sqrt(a)))
            //dist = number_format(dist, 2, '.', '');
            return dist; // em km
        },
        areaDoQuadrilatero(b, h) {
            return b * h
        },
        salvarPonto() {
            const layer = desenhos.getLayers()[0]
            if (layer instanceof L.Rectangle) {
                const pontos = layer.getLatLngs()[0]
                axios.post('/empresa/pontos/createPonto', { pontos, nome: this.nome })
                    .then(r => {
                        console.log(r.data)
                    })
                    .catch(e => console.log(e.message))
            } else {

            }

        },
        getMarkers() {
            return markers
        },
        getDesenhos() {
            return desenhos
        },
        clearDesenhos() {
            markers.clearLayers()
        },
        clearMarkers() {
            if (desenhos.getLayers()[0] instanceof L.Rectangle) {
                desenhos.getLayers()[0].transform.disable()
            }
            desenhos.clearLayers()
            this.desenhos = false;
        },
        clearAll() {
            this.clearMarkers()
            this.clearDesenhos()
        }
    },
    created() {

    },

    mounted() {

        map = L.map('map', {
            scrollWheelZoom: true
        });
        map.setView([-15.797076100943771, -47.87551860828078], 2);
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OSM Mapnik <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        markers = new L.LayerGroup()
        desenhos = new L.LayerGroup();
        markers.addTo(map);
        desenhos.addTo(map);

        const clearMarkers = this.clearMarkers

        const removeFirstLayer = () => {
            const layers = markers.getLayers()
            if (layers.length) {
                markers.removeLayer(layers.shift())
            }
        }

        const clearDesenhos = this.clearDesenhos

        /* const clearAll = () => {
            clearMarkers()
            clearDesenhos()
        } */

        const limite = () => {
            if (document.getElementById('circulo').checked) {
                if (markers.getLayers().length >= 1) {
                    removeFirstLayer()
                }
            } else {
                if (markers.getLayers().length >= 4) {
                    removeFirstLayer()
                }
            }
        }

        const provider = new GeoSearch.OpenStreetMapProvider();
        const searchControl = new GeoSearch.GeoSearchControl({
            provider: provider,
        });

        map.addControl(searchControl);
        map.on('click', function (e) {
            if (!desenhos.getLayers().length) {
                const marker = L.marker(e.latlng)
                limite()
                marker.addTo(markers)
            }
        })
    }
}
</script>
