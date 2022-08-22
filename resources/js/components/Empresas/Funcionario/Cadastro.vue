<template>
  <section class="w-full h-[30vw]">
    <div class="w-full p-5">
      <form action="#" @submit.prevent="cadastrarFuncionario">
        <o-field label="Nome">
          <o-input
            type="text"
            placeholder="João..."
            v-model="form.name"
            required
          >
          </o-input>
        </o-field>
        <o-field label="Email">
          <o-input
            type="email"
            placeholder="jao@"
            v-model="form.email"
            required
          >
          </o-input>
        </o-field>
        <o-button native-type="submit">Cadastrar</o-button>
        <!-- <o-field label="Função">
      <o-input type="text" value="john@" required> </o-input>
    </o-field>
    <o-field label="Inicio">
      <o-input type="time" value="john@" required> </o-input>
    </o-field>
    <o-field label="Termino">
      <o-input type="time" value="john@" required> </o-input>
    </o-field> -->
      </form>
    </div>
  </section>
</template>


<script>
export default {
  data: () => {
    return {
      id: null,
      form: {},
      formResponse: {},
    };
  },
  methods: {
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
      </div>
    </div>
    `,
        closable: true,
        position: "bottom-right",
        variant: "success",
        indefinite: true,
      });
      const response = this.getFormResponse;
      document
        .getElementById("copiarValor")
        .addEventListener("click", function (e) {
          console.log("teste");
          navigator.clipboard.writeText(
            `Email: ${response().email}, password: ${response().pass}`
          );
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
};
</script>
