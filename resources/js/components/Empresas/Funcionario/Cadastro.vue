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
          <o-field label="Tolerancia(em min)" title="em minutos" class="w-full md:w-1/4 md:mr-5">
            <o-input
              type="number"
              v-model="form.tolerancia"
              placeholder="Tempo para contar atraso"
              required
            >
            </o-input>
          </o-field>
        </div>
        <div>
          <o-field label="Pausas">
            <div class="flex flex-col max-h-48 overflow-y-auto space-y-3 hover:divide-y-2 divide-black">
              <div v-for="(pausa, key) in form.pausas" :key="key">
                <div class="flex flex-col w-full">
                  <o-field label="Nome da pausa">
                    <o-input
                      type="text"
                      v-model="form.pausas[key].nome"
                      placeholder="Nome da pausa"
                      required
                    />
                  </o-field>
                  <o-field label="Horário">
                    <o-input
                      type="time"
                      v-model="form.pausas[key].horario"
                      required
                    />
                  </o-field>
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
      },
      formResponse: {},
    };
  },
  methods: {
    morePausas() {
      this.form.pausas.push({ nome: null, horario: null });
    },
    minusPausas() {
      this.form.pausas.pop();
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
    this.form.pausas.push({ nome: "Almoço", horario: "12:00" });
  },
};
</script>
