<template>
  <section class="w-full h-screen">

    <div class="w-full h-full p-5">
        <div class="mb-4 ml-2">
            <router-link to="/empresa/funcionario/cadastro" class="bg-green-500 px-4 py-2 rounded-md border-2 border-green-700 text-white font-bold">Novo</router-link>
        </div>

      <o-table
        :data="isEmpty ? [] : data"
        :bordered="isBordered"
        :striped="isStriped"
        :narrowed="isNarrowed"
        :hoverable="isHoverable"
        :loading="isLoading"
        :focusable="isFocusable"
        :mobile-cards="hasMobileCards"
      >
        <!-- <o-table-column field="id" label="ID" width="40" numeric v-slot="props">
                                    {{ props.row.id }}
                                </o-table-column> -->
        <o-table-column label="Criado" v-slot="props">
          <small
            class="has-text-grey is-abbr-like"
            :title="props.row.created_at"
            >{{ dataValue(props.row.created_at) }}</small
          >
        </o-table-column>
        <o-table-column field=".funcionario.name" label="Nome" v-slot="props">
          {{ props.row.funcionario.name }}
        </o-table-column>
        <o-table-column field=".funcionario.email" label="Email" v-slot="props">
          {{ props.row.funcionario.email }}
        </o-table-column>
        <o-table-column v-slot="props">
          <div class="buttons">
            <!-- <button
              v-if="!props.row.deleted_at"
              @click.prevent="testarPonto(props.row)"
              class="button is-small mr-4"
              type="button"
            >
              Testar
            </button> -->
            <!-- <a
              href="#/relatorios"
              title="Apenas para testes"
              v-if="!props.row.deleted_at"

              class="button is-small mr-4"
              type="button"
            >
              Relatorios
            </a> -->
            <router-link :to="{ name: 'relatorios', params: { id: props.row.id } }" class="button is-small mr-4">Relatorios</router-link>
            <button
              title="Apenas para testes"
              v-if="!props.row.deleted_at"
              @click.prevent="redefinirSenha(props.row)"
              class="button is-small mr-4"
              type="button"
            >
              Redefinir senha
            </button>
            <!-- <button
              v-if="props.row.deleted_at"
              class="button is-small"
              type="button"
            >
              Restaurar
            </button>
            <button
              v-if="!props.row.deleted_at"
              class="button is-small is-danger"
              type="button"
            >
              Desativar
            </button>
            <button v-else class="button is-small is-danger" type="button">
              Excluir
            </button> -->
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
    <!-- <relatorios-funcionario :ativar-modal="ativarModal" @fechar="fecharModalRelatorios" /> -->
  </section>
</template>


<script>
export default {
  name: "Home",
  data: function () {
    return {
      // tabela
      data: [],
      isEmpty: false,
      isBordered: false,
      isStriped: false,
      isNarrowed: false,
      isHoverable: false,
      isFocusable: false,
      isLoading: false,
      hasMobileCards: true,

      // rounting
      telaRelatorioFuncionario: "#/relatorio-funcionario",
    };
  },
  methods: {
    componentN(pass) {
      this.$oruga.notification.open({
        message: `
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">Sucesso!</p>
      </header>
      <div>
      <div class="flex justify-end text-xs"><button id="copiarValor">Copiar</button></div>
        <div class="flex">
          <span class="font-bold">Senha:</span>
          <input class="pl-1 w-auto bg-transparent outline-0" id="textCopy" readonly value="${pass}"/>
        </div>
      </div>
    </div>
    `,
        closable: true,
        position: "bottom-right",
        variant: "success",
        indefinite: true,
      });
      function copiar() {
        let copyText = document.querySelector("#textCopy");
        copyText.select();
        document.execCommand("copy");
        document.getElementById("copiarValor").focus();
      }

      document
        .getElementById("copiarValor")
        .removeEventListener("click", copiar);
      document.getElementById("copiarValor").addEventListener("click", copiar);
    },
    relatoriosFuncionario(row) {
      // this.$oruga.modal.open({
      //   // parent is only for Vue2. in Vue 3 omit this option
      //   // parent: this,
      //   component: RelatoriosFuncionario,
      //   trapFocus: true,
      // })
      // axios
      // .get("/empresa/relatorios/" + row.funcionario.id)
      // .then((r) => {
      // })
      // .catch((e) => console.log(e.message));
    },
    redefinirSenha(row) {
      axios
        .get("/empresa/redefinirsenha/" + row.funcionario.id)
        .then((r) => {
          if (r.data) {
            this.componentN(r.data.pass);
          }
        })
        .catch((e) => console.log(e.message));
    },
    getData() {
      axios
        .get("/empresa/funcionarios")
        .then((r) => {
          if (r.data) {
            this.data = r.data;
          }
        })
        .catch((e) => console.log(e.message));
    },

    dataValue(data) {
      const d = data.split("T")[0].split("-");
      //console.log(data)
      return new Date(d).toLocaleString("pt-BR", {
        year: "numeric",
        month: "numeric",
        day: "numeric",
      });
    },
  },
  created() {
    this.getData();
    axios.get("/empresa/user").then((r) => {
      if (r.data) {
        this.$store.commit("setEmpresa", r.data);
      }
    });
  },
};
</script>
