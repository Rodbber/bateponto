<template>
    <div class="w-full h-full">
        Verificação de pontos
        <div class="p-5 flex flex-col md:flex-row">
            <div id="map" class="min-w-max h-[40vh] md:w-[50vw] md:h-[80vh]"></div>
            <div class="pl-5 flex-1">
                <o-tabs v-model="activeTab" :multiline="multiline">
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
                                <section class="section" v-if="isEmpty">
                                    <div class="content has-text-grey has-text-centered">
                                        <template v-if="isLoading">
                                            <p>
                                                <mdicon name="dots-horizontal" />
                                            </p>
                                            <p>Procurando registros...</p>
                                        </template>
                                        <template v-else>
                                            <p>
                                                <mdicon name="emoticon-sad" />
                                            </p>
                                            <p>Nenhum registro encontrado&hellip;</p>
                                        </template>
                                    </div>
                                </section>
                            </o-table>
                        </div>
                    </o-tab-item>
                    <o-tab-item value="0" label="Cadastrar">
                        <div class="mb-4 w-full">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nomePonto">
                                Nome do ponto
                            </label>
                            <input v-model="nome"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="nomePonto" type="text" placeholder="Nome do ponto">
                        </div>
                        <div v-if="!id">
                            <span>Tipo</span>
                            <div class="form-check">
                                <input
                                    class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="radio" name="TIPO" id="poligono" value="0" checked @change="changeRadioValue">
                                <label class="form-check-label inline-block text-gray-800" for="poligono">
                                    Poligono
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="radio" name="TIPO" id="quadrilatero" value="1" @change="changeRadioValue">
                                <label class="form-check-label inline-block text-gray-800" for="quadrilatero">
                                    Quadrilatero
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="radio" name="TIPO" id="circulo" value="2" @change="changeRadioValue">
                                <label class="form-check-label inline-block text-gray-800" for="circulo">
                                    Circulo
                                </label>
                            </div>


                        </div>
                        <div>
                            <div class="flex-1" v-if="!desenhos">
                                <button type="button"
                                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full md:w-auto"
                                    @click="aplicarForma">Aplicar</button>
                            </div>
                            <div class="flex flex-col w-full md:w-auto space-y-2 py-2">
                                <div class="flex-1 md:flex-auto">
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
    name:'PontosEmpresa',
    created() {
        axios.get('/empresa/user')
            .then(r => {
                if (r.data) {
                    this.$store.commit('setEmpresa', r.data)
                }
            })
    },
    data: () => {
        const data = []

        return {
            map: null,
            markers: null,
            desenhos: false,
            nome: null,
            tipoForma: null,
            testaponto: false,

            //tabs
            activeTab: 1,
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

        error(message) {
            const notif = this.$oruga.notification.open({
                duration: 5000,
                message: message,
                position: 'top',
                variant: 'danger',
                closable: true,
                /* onClose: () => {
                    this.$oruga.notification.open('Custom notification closed!')
                } */
            })
        },
        success(message) {
            this.$oruga.notification.open({
                message: message,
                position: 'top',
                variant: 'success',
                duration: 2000
            })
        },
        changeRadioValue(n) {
            console.log(n.target.value)
            this.tipoForma = n.target.value
        },
        testarPonto(row) {
            this.clearDesenhos()
            this.id = row.id
            this.testaponto = true;
            const pontos = row.pontos ? JSON.parse(row.pontos) : null
            if (pontos) {
                if (row.tipo === 'QUADRILATERO') {
                    this.quadrilatero(pontos, this.nome, 18)
                } else if (row.tipo === 'POLIGONO') {
                    this.poligono(pontos, this.nome, 18)
                }
                this.desenhos = true;

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
        centerOfPolygon(arr) {
            var twoTimesSignedArea = 0;
            var cxTimes6SignedArea = 0;
            var cyTimes6SignedArea = 0;

            var length = arr.length

            var x = function (i) { return arr[i % length][0] };
            var y = function (i) { return arr[i % length][1] };

            for (var i = 0; i < arr.length; i++) {
                var twoSA = x(i) * y(i + 1) - x(i + 1) * y(i);
                twoTimesSignedArea += twoSA;
                cxTimes6SignedArea += (x(i) + x(i + 1)) * twoSA;
                cyTimes6SignedArea += (y(i) + y(i + 1)) * twoSA;
            }
            var sixSignedArea = 3 * twoTimesSignedArea;
            return isNaN(cxTimes6SignedArea / sixSignedArea) || isNaN(cyTimes6SignedArea / sixSignedArea) ? null : [cxTimes6SignedArea / sixSignedArea, cyTimes6SignedArea / sixSignedArea];
        },
        poligono(coords, nome = null, zoom = null) {
            var polygon = L.polygon(coords, { transform: true, draggable: true }).addTo(desenhos);
            setTimeout(() => {
                polygon.dragging.enable();
                polygon.transform.enable({ rotation: true, uniformScaling: false });
            }, 100);


            if (nome) {
                polygon.bindPopup(`<div>Nome des ponto:${nome}</div>`)
                polygon.openPopup()
            }

            if (zoom) {
                const centro = this.centerOfPolygon(coords.map(c => [c.lat, c.lng]))

                if (centro) {
                    map.setView(centro, zoom)
                } else {
                    map.setView(coords[0], zoom)
                }
            }
        },
        quadrilatero(coords, nome = null, zoom = null) {
            let r = L.rectangle(coords, { transform: true, draggable: true }).addTo(desenhos)

            setTimeout(() => {
                r.dragging.enable();
                r.transform.enable({ rotation: true, uniformScaling: false });
            }, 100);
            r.setLatLngs(coords);
            if (nome) {
                r.bindPopup(`<div>${nome}</div>`)
                r.openPopup()
            }

            if (zoom) {
                const centro = this.centerOfPolygon(coords.map(c => [c.lat, c.lng]))
                if (centro) {
                    map.setView(centro, zoom)
                } else {
                    map.setView(coords[0], zoom)
                }
            }
        },
        aplicarForma() {
            const variosPontos = markers.getLayers().length
            if (variosPontos >= 2) {
                const markersSelecionados = []
                for (let i of markers.getLayers()) {
                    markersSelecionados.push(i.getLatLng())
                }
                if (this.tipoForma === '1') {
                    this.quadrilatero(markersSelecionados, this.nome, 18)
                } else if (this.tipoForma === '0') {
                    this.poligono(markersSelecionados, this.nome, 18)
                }
                //const coordCentro = this.centerOfPolygon(markersSelecionados.map(c => [c.lat, c.lng]))
                this.desenhos = true;
                markers.clearLayers()
                /* const marker = L.marker(coordCentro)
                marker.addTo(markers) */
            }
        },
        editaPonto(row) {
            this.clearDesenhos()
            this.id = row.id
            this.activeTab = '0'
            this.nome = row.nome
            const pontos = row.pontos ? JSON.parse(row.pontos) : null
            if (row.tipo === 'QUADRILATERO' && pontos) {
                this.quadrilatero(pontos, this.nome, 18)
                this.desenhos = true;
            } else if (row.tipo === 'POLIGONO' && pontos) {
                this.desenhos = true;
                this.poligono(pontos, this.nome, 18)
            }
            markers.clearLayers()
        },
        salvarPonto() {
            const layer = desenhos.getLayers()[0]
            if (layer instanceof L.Rectangle) {
                const pontos = layer.getLatLngs()[0]
                if (!this.id) {
                    axios.post('/empresa/pontos/quadrilatero/createPonto', { pontos, nome: this.nome })
                        .then(r => {
                            this.success('Quadrilatero cadastrado')
                        })
                        .catch(e => {
                            console.log(e.message)
                            this.error('Erro ao cadastrar quadrilatero')
                        })
                } else {
                    axios.post('/empresa/pontos/quadrilatero/update/' + this.id, { pontos, nome: this.nome })
                        .then(r => {
                            this.success('Quadrilatero editado')
                        })
                        .catch(e => {
                            console.log(e.message)
                            this.error('Erro ao editar quadrilatero')
                        })
                }

            } else if (layer instanceof L.Polygon) {
                const pontos = layer.getLatLngs()[0]
                if (!this.id) {
                    axios.post('/empresa/pontos/poligono/createPonto', { pontos, nome: this.nome })
                        .then(r => {
                            this.success('Poligono cadastrado')
                        })
                        .catch(e => {
                            console.log(e.message)
                            this.error('Erro ao cadastrar poligono')
                        })
                } else {
                    axios.post('/empresa/pontos/poligono/update/' + this.id, { pontos, nome: this.nome })
                        .then(r => {
                            this.success('Quadrilatero editado')
                        })
                        .catch(e => {
                            console.log(e.message)
                            this.error('Erro ao editar poligono')
                        })
                }
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
            if (desenhos.getLayers().length) {
                if (desenhos.getLayers()[0] instanceof L.Rectangle || desenhos.getLayers()[0] instanceof L.Polygon) {
                    desenhos.getLayers()[0].transform.disable()
                }
                desenhos.clearLayers()
                this.desenhos = false;
            }

        },
        clearMarkers() {
            if (markers.getLayers().length) {
                markers.clearLayers()
            }
        },
        clearAll() {
            this.clearMarkers()
            this.clearDesenhos()
            //map.setView([-15.797076100943771, -47.87551860828078], 2);
        },
        getPontos() {
            this.data = []
            //return;
            axios.get('/empresa/pontos/poligono/get')
                .then(r => {
                    if (r.data) {
                        if (this.data.length) {
                            this.data = [...this.data, ...r.data]
                        } else {
                            this.data = r.data
                        }
                    }
                })
                .catch(e => console.log(e.message))
            axios.get('/empresa/pontos/quadrilatero/get')
                .then(r => {
                    if (r.data) {
                        if (this.data.length) {
                            this.data = [...this.data, ...r.data]
                        } else {
                            this.data = r.data
                        }

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
                //map.setView([-15.797076100943771, -47.87551860828078], 2);
                this.id = null
                this.nome = null
            } else {
                this.tipoForma = '0'
            }
        }
    },
    mounted() {
        //console.log(this.$store.state.empresa)
        this.tipoForma = '0'
        this.getPontos()
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

        const limitePontos = this.tipoForma

        const limite = () => {
            if (limitePontos === '2') {
                if (markers.getLayers().length >= 1) {
                    removeFirstLayer()
                }
            } else if (limitePontos === '1') {
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
                    //console.log(testaponto())
                    const lat = e.latlng.lat
                    const lng = e.latlng.lng
                    markers.clearLayers()
                    const marker = L.marker(e.latlng)
                    //marker.dragging.enable();
                    marker.addTo(markers)

                    const markerEsperando = `Verificando...`
                    marker.bindPopup(`<div>${markerEsperando}</div>`)
                    marker.openPopup()
                    const markerDentro = `marker dentro`
                    const markerFora = `marker fora`
                    //console.log(this.$store.state.empresa)
                    axios.post('/empresa/pontos/validarPontoDentro/' + getid(), { lat, lng })
                        .then(r => {
                            //console.log(r.data)
                            if (r.data) {
                                marker.setPopupContent(`<div>${markerDentro}</div>`)
                            } else {
                                marker.setPopupContent(`<div>${markerFora}</div>`)
                            }
                            if (!marker.isPopupOpen()) {
                                marker.openPopup()
                            }
                        })
                        .catch(e => {
                            console.log(e.message)
                            marker.setPopupContent(`<div>Error!</div>`)
                            if (!marker.isPopupOpen()) {
                                marker.openPopup()
                            }
                        })
                }
            }

        })
    }
}
</script>
