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
    };
  },
  methods: {
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
      .then(r => {
        console.log(r.data)
      })
      .catch(e => console.log(e.message))
    },
  },
};
</script>
