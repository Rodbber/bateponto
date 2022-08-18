<template>
    <div class="w-full h-full">
        Verificação de pontos
        <div class="p-5 flex flex-col md:flex-row">
            <div id="map" class="min-w-max h-[40vh] md:w-[50vw] md:h-[80vh]"></div>
            <div class="pl-5 flex-1">
                <o-tabs v-model="activeTab" :multiline="multiline">
                    <o-tab-item value="0" label="Cadastrar">
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
                    </o-tab-item>

                    <o-tab-item :value="1" label="Pontos cadastrados">
                        <div class="mt-5">
                            <o-table :data="isEmpty ? [] : data" :bordered="isBordered" :striped="isStriped"
                                :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading"
                                :focusable="isFocusable" :mobile-cards="hasMobileCards">
                                <!-- <o-table-column field="id" label="ID" width="40" numeric v-slot="props">
                                    {{ props.row.id }}
                                </o-table-column> -->
                                <o-table-column label="Criado" v-slot="props">
                                    <small class="has-text-grey is-abbr-like" :title="props.row.created_at">{{
                                            dataValue(props.row.created_at)
                                    }}</small>
                                </o-table-column>
                                <o-table-column field="nome" label="Nome do ponto" v-slot="props">
                                    {{ props.row.nome }}
                                </o-table-column>
                                <o-table-column v-slot="props">
                                    <div class="buttons">
                                        <button v-if="!props.row.deleted_at" @click.prevent="testarPonto(props.row)"
                                            class="button is-small mr-4" type="button">
                                            Testar
                                        </button>
                                        <button v-if="!props.row.deleted_at" @click.prevent="editaPonto(props.row)"
                                            class="button is-small mr-4" type="button">
                                            Editar
                                        </button>
                                        <button v-if="props.row.deleted_at" class="button is-small" type="button">
                                            Restaurar
                                        </button>
                                        <button v-if="!props.row.deleted_at" class="button is-small is-danger"
                                            type="button">
                                            Desativar
                                        </button>
                                        <button v-else class="button is-small is-danger" type="button">
                                            Excluir
                                        </button>
                                    </div>
                                </o-table-column>

                                <!-- <o-table-column field="last_name" label="Last Name" v-slot="props">
                                    {{ props.row.last_name }}
                                </o-table-column> -->

                                <!-- <o-table-column field="date" label="Date" position="centered" v-slot="props">
                                    {{ new Date(props.row.date).toLocaleDateString() }}
                                </o-table-column>

                                <o-table-column label="Gender" v-slot="props">
                                    <span>
                                        <o-icon pack="fas" :icon="props.row.gender === 'Male' ? 'mars' : 'venus'">
                                        </o-icon>
                                        {{ props.row.gender }}
                                    </span>
                                </o-table-column> -->
                            </o-table>
                        </div>
                    </o-tab-item>
                </o-tabs>




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
        const data = [
            /* {
                id: 1,
                first_name: 'Jesse',
                last_name: 'Simmons',
                date: '2016/10/15 13:43:27',
                gender: 'Male'
            },
            {
                id: 2,
                first_name: 'John',
                last_name: 'Jacobs',
                date: '2016/12/15 06:00:53',
                gender: 'Male'
            },
            {
                id: 3,
                first_name: 'Tina',
                last_name: 'Gilbert',
                date: '2016/04/26 06:26:28',
                gender: 'Female'
            },
            {
                id: 4,
                first_name: 'Clarence',
                last_name: 'Flores',
                date: '2016/04/10 10:28:46',
                gender: 'Male'
            },
            {
                id: 5,
                first_name: 'Anne',
                last_name: 'Lee',
                date: '2016/12/06 14:38:38',
                gender: 'Female'
            } */
        ]

        return {
            map: null,
            markers: null,
            desenhos: false,
            nome: null,
            testaponto: false,

            //tabs
            activeTab: '0',
            multiline: false,

            // tabela
            data,
            isEmpty: false,
            isBordered: false,
            isStriped: false,
            isNarrowed: false,
            isHoverable: false,
            isFocusable: false,
            isLoading: false,
            hasMobileCards: true,

            //editar ponto
            id: null,

        }
    },
    methods: {
        testarPonto(row) {
            this.id = row.id
            this.testaponto = true;
            if (row.pontos) {
                const pontos = JSON.parse(row.pontos)
                map.setView(pontos[0], 7);
                let r = L.rectangle(pontos, { transform: true, draggable: true }).addTo(desenhos)
                r.dragging.enable();
                this.desenhos = true;
                //r.transform.enable();
                r.transform.enable({ rotation: true, uniformScaling: false });
            }

        },
        dataValue(data) {
            const d = data.split('T')[0].split('-')
            //console.log(data)
            return new Date(d).toLocaleString('pt-BR', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
            })
        },
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
        editaPonto(row) {
            this.id = row.id
            this.activeTab = '0'
            this.nome = row.nome
            if (row.pontos) {
                const pontos = JSON.parse(row.pontos)
                map.setView(pontos[0], 7);
                let r = L.rectangle(pontos, { transform: true, draggable: true }).addTo(desenhos)
                r.dragging.enable();
                this.desenhos = true;
                //r.transform.enable();
                r.transform.enable({ rotation: true, uniformScaling: false });
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
                if (!this.id) {
                    axios.post('/empresa/pontos/createPonto', { pontos, nome: this.nome })
                        .then(r => {
                            console.log(r.data)
                        })
                        .catch(e => console.log(e.message))
                } else {
                    axios.post('/empresa/pontos/quadrilatero/update/' + this.id, { pontos, nome: this.nome })
                        .then(r => {
                            console.log(r.data)
                        })
                        .catch(e => console.log(e.message))
                }

            } else {

            }

        },
        getId() {
            return this.id
        },
        getTestarPonto() {
            return this.testaponto
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
        },
        getPontos() {
            axios.get('/empresa/pontos/quadrilatero/get')
                .then(r => {
                    if (r.data) {
                        this.data = r.data
                    }
                })
                .catch(e => console.log(e.message))

        },

    },
    watch: {
        activeTab(n) {
            if (n === 1) {
                this.clearAll()
                this.getPontos()
                this.id = null
                this.nome = null
            }
        }
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

        let testaponto = this.getTestarPonto
        let getid = this.getId

        map.addControl(searchControl);
        map.on('click', function (e) {

            if (!testaponto()) {
                if (!desenhos.getLayers().length) {
                    const marker = L.marker(e.latlng)
                    limite()
                    marker.addTo(markers)
                }
            } else {
                if (desenhos.getLayers().length) {
                    console.log(testaponto())
                    const lat = e.latlng.lat
                    const lng = e.latlng.lng
                    axios.post('/empresa/pontos/validarPontoDentro/' + getid(), { lat, lng })
                        .then(r => console.log(r.data))
                        .catch(e => console.log(e.message))
                }
            }

        })
    }
}
</script>
