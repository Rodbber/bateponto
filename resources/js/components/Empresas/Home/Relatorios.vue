<template>
  <div>
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
      <o-table-column field="created_at" label="Entrada" v-slot="props">
        <small
          class="has-text-grey is-abbr-like"
          :title="props.row.created_at"
          >{{ dataValue(props.row.created_at) }}</small
        >
      </o-table-column>
      <o-table-column field=".funcionario_ponto_final.created_at" label="Saida" v-slot="props">
        <small
          class="has-text-grey is-abbr-like"
          :title="props.row.created_at"
          >{{ props.row.funcionario_ponto_final ? dataValue(props.row.funcionario_ponto_final.created_at) : '-' }}</small
        >
      </o-table-column>
      <o-table-column field=".funcionario_ponto_pausa.created_at" label="Pausas" v-slot="props">
        <small
          class="has-text-grey is-abbr-like"
          :title="props.row.created_at"
          >{{ props.row.funcionario_ponto_pausa ? ""+dataValue(props.row.funcionario_ponto_pausa.func_intervalo_fim.created_at)+" até "+dataValue(props.row.funcionario_ponto_pausa.created_at) : '-' }}</small
        >
      </o-table-column>
      <!-- <o-table-column v-slot="props">
        <div class="buttons">
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
</template>

<script>
export default {
  name: "RelatoriosFuncionario",
  props:['id'],
  data: () => {
    return {
      //id: null,
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
      if (this.id) {
        axios
          .get("/empresa/funcionario/batepontos/" + this.id)
          .then((r) => {
              console.log(r.data);
            if (r.data) {
              this.data = r.data;
            }else {
                this.isEmpty = true
            }
          })
          .catch((e) => console.log(e.message));
      }
    },
    dataValue(data) {
      //const d = data.split('T')[0].split('-')
      //console.log(data)
      return new Date(data).toLocaleString('pt-BR', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
      })
    },
  },
  watch: {
    id(n) {
        console.log(this.id)
      if (n) {
        this.getData();
      }
    },
  },
  created() {
    this.getData();
  },
};
</script>
