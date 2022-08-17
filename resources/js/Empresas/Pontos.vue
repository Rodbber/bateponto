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
                    <input
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
                                @click="aplicarForma">Salvar</button>
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

let map
let markers
let desenhos

export default {
    data: () => {
        return {
            map: null,
            markers: null,
            desenhos: false,

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
            desenhos.clearLayers()
            this.desenhos = true;
        },
        clearAll() {
            clearMarkers()
            clearDesenhos()
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
