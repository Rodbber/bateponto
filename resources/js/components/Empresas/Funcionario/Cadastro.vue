<template>
  <section class="w-full">
    <div class="w-full p-5">
      <form action="#" @submit.prevent="cadastrarFuncionario">
        <div class="flex flex-col md:flex-row">
          <o-field label="Nome" class="w-full md:w-1/2 md:mr-5">
            <o-input
              type="text"
              placeholder="João..."
              v-model="form.name"
              required
            >
            </o-input>
          </o-field>
          <o-field label="Email" class="w-full md:w-1/2">
            <o-input
              type="email"
              placeholder="jao@"
              v-model="form.email"
              required
            >
            </o-input>
          </o-field>
        </div>
        <div class="flex flex-col md:flex-row">
          <o-field label="Função" class="w-full md:w-1/4 md:mr-5">
            <o-input
              type="text"
              placeholder="estagiario, engenheiro Junior, cozinheiro..."
              v-model="form.funcao"
              required
            >
            </o-input>
          </o-field>
          <o-field label="Inicio" class="w-full md:w-1/4 md:mr-5">
            <o-input type="time" v-model="form.inicio" required> </o-input>
          </o-field>
          <o-field label="Termino" class="w-full md:w-1/4 md:mr-5">
            <o-input type="time" v-model="form.fim" required> </o-input>
          </o-field>
          <o-field
            label="Tolerancia(em min)"
            title="em minutos"
            class="w-full md:w-1/4"
          >
            <o-input
              type="number"
              v-model="form.tolerancia"
              placeholder="Tempo para contar atraso"
              required
            >
            </o-input>
          </o-field>
        </div>
        <div class="flex flex-col md:flex-row">
          <div class="w-full md:w-1/2 mr-5">
            <o-field label="Pausas">
              <div
                class="
                  flex flex-col
                  max-h-48
                  overflow-y-auto
                  space-y-3
                  hover:divide-y-2
                  divide-black
                "
              >
                <div v-for="(pausa, key) in form.pausas" :key="key">
                  <div class="flex flex-col w-full lg:flex-row">
                    <o-field
                      label="Nome da pausa"
                      class="w-full lg:w-1/2 lg:mr-5"
                    >
                      <o-input
                        type="text"
                        v-model="form.pausas[key].nome"
                        placeholder="Nome da pausa"
                        required
                      />
                    </o-field>
                    <div class="flex flex-col md:flex-row">
                      <o-field label="Padrão" class="w-full md:mr-5 lg:w-1/2">
                        <o-input
                          type="time"
                          v-model="form.pausas[key].horario"
                          required
                        />
                      </o-field>
                      <o-field label="Periodo (minutos)" class="w-full lg:1/2">
                        <o-input
                          type="number"
                          v-model="form.pausas[key].tempo"
                          required
                        />
                      </o-field>
                    </div>
                  </div>
                </div>
              </div>
            </o-field>

            <div class="flex flex-col justify-center items-center">
              <span>Controle de pausas</span>
              <div class="flex flex-row space-x-2">
                <o-button native-type="button" @click="minusPausas">-</o-button>
                <o-button native-type="button" @click="morePausas">+</o-button>
              </div>
            </div>
          </div>
          <div class="w-full md:w-1/2">
            <o-field label="Pontos">
              <div
                class="
                  flex flex-col
                  max-h-48
                  overflow-y-auto
                  space-y-3
                  hover:divide-y-2
                  divide-black
                  w-full
                "
              >
                <div v-for="(ponto, key) in form.pontos" :key="key">
                  <o-field label="Selecione um ponto" class="w-full">
                    <o-select
                      placeholder="Selecione um ponto para este funcionario"
                      class="w-full"
                      expanded
                      v-model="form.pontos[key]"
                    >
                      <option
                        v-for="(item, index) in pontos"
                        v-bind:key="index"
                        v-bind:value="{ id: item.id, tipo: item.tipo }"
                      >
                        {{ item.nome }}
                      </option>
                    </o-select>
                  </o-field>
                </div>
              </div>
            </o-field>

            <div class="flex flex-col justify-center items-center">
              <span>Controle de pontos</span>
              <div class="flex flex-row space-x-2">
                <o-button
                  native-type="button"
                  @click="minusPontos"
                  v-if="verificacaoDePontosPeloMenos1"
                  >-</o-button
                >
                <o-button
                  native-type="button"
                  @click="morePontos"
                  v-if="verificacaoDePontosMaiorQueExistentes"
                  >+</o-button
                >
              </div>
            </div>
          </div>
        </div>

        <div class="flex justify-end">
          <o-button native-type="submit">Cadastrar</o-button>
        </div>
      </form>
    </div>
  </section>
</template>


<script>
export default {
  data: () => {
    return {
      id: null,
      form: {
        pausas: [],
        pontos: [],
      },
      formResponse: {},
      pontos: [],
    };
  },
  computed: {
    verificacaoDePontosMaiorQueExistentes() {
      return this.form.pontos.length < this.pontos.length;
    },
    verificacaoDePontosPeloMenos1() {
      return this.form.pontos.length > 1;
    },
  },
  methods: {
    getPontosEmpresa() {
      let method = "GET";
      let url = "/empresa/pontos/quadrilatero/get/ativos";
      axios({
        method,
        url,
      })
        .then((r) => {
          if (r.data) {
            this.pontos = r.data;
          }
          let method = "GET";
          let url = "/empresa/pontos/poligono/get/ativos";
          axios({
            method,
            url,
          })
            .then((r) => {
              if (r.data) {
                this.pontos = [...this.pontos, ...r.data];
              }
            })
            .catch((e) => console.log(e.message));
        })
        .catch((e) => console.log(e.message));
    },
    morePausas() {
      this.form.pausas.push({ nome: null, horario: null });
    },
    minusPausas() {
      this.form.pausas.pop();
    },
    morePontos() {
      this.form.pontos.push({ id: null, tipo: null });
    },
    minusPontos() {
      this.form.pontos.pop();
    },

    componentToast(data) {
      this.$oruga.notification.open({
        message: `
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">Sucesso!</p>
      </header>
      <div>
      <div class="flex justify-end text-xs"><button id="copiarValor">Copiar</button></div>
        <div class="flex">
          <span class="font-bold">Email:</span>
          <span>${data.email}</span>
        </div>
        <div class="flex">
          <span class="font-bold">Senha:</span>
          <span>${data.pass}</span>
        </div>
        <input class="pl-1 w-auto bg-transparent outline-0 text-transparent" id="textCopy" readonly value="email:${data.email}, senha:${data.pass}"/>
      </div>
    </div>
    `,
        closable: true,
        position: "bottom-right",
        variant: "success",
        indefinite: true,
      });
      //const response = this.getFormResponse;
      document
        .getElementById("copiarValor")
        .addEventListener("click", function (e) {
          let copyText = document.querySelector("#textCopy");
          copyText.select();
          document.execCommand("copy");
          document.getElementById("copiarValor").focus();
        });
    },
    cadastrarFuncionario() {
      let method = "POST";
      let url = "/empresa/funcionario/create";
      if (!this.id) {
        let method = "PATCH";
        let url = "/empresa/funcionario/update";
      }

      axios({
        method,
        url,
        data: this.form,
      })
        .then((r) => {
          if (r.data) {
            console.log(r.data);
            this.formResponse = r.data;
            this.componentToast(this.formResponse);
          }
        })
        .catch((e) => console.log(e.message));
    },
    getFormResponse() {
      return this.formResponse;
    },
  },
  mounted() {
    this.getPontosEmpresa();
    this.form.pausas.push({ nome: "Almoço", horario: "12:00", tempo: 60 });
    this.morePontos();
  },
};
</script>
