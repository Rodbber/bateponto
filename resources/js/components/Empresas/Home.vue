<template>
  <section class="w-full h-screen">
    <div class="w-full h-full p-5">
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
        <!-- <o-table-column v-slot="props">
          <div class="buttons">
            <button
              v-if="!props.row.deleted_at"
              @click.prevent="testarPonto(props.row)"
              class="button is-small mr-4"
              type="button"
            >
              Testar
            </button>
            <button
              v-if="!props.row.deleted_at"
              @click.prevent="editaPonto(props.row)"
              class="button is-small mr-4"
              type="button"
            >
              Editar
            </button>
            <button
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
            </button>
          </div>
        </o-table-column> -->
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
  </section>
</template>

<script>
export default {
  name: "HomeEmpresa",
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
    };
  },

  methods: {
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
