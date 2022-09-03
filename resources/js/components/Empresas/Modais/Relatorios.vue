<template>
    <div class="modal-card" :mobileBreakpoint="900">
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
        <o-table-column field="emtrada" label="Entrada" v-slot="props">
          <small
            class="has-text-grey is-abbr-like"
            :title="props.row.created_at"
            >{{ dataValue(props.row.created_at) }}</small
          >
        </o-table-column>
        <o-table-column field="saida" label="Saida" v-slot="props">
          {{ props.row.funcionario.name }}
        </o-table-column>
        <o-table-column field=".funcionario.email" label="Pausas" v-slot="props">
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
            <button
              title="Apenas para testes"
              v-if="!props.row.deleted_at"
              @click.prevent="relatoriosFuncionario(props.row)"
              class="button is-small mr-4"
              type="button"
            >
              Relatorios
            </button>
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
</template>

<script>
export default {
  name: "RelatoriosFuncionario",
  data: () => {
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

  },
  watch:{
  },
};
</script>
