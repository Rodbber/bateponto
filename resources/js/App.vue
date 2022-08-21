<template>
    <div>
        <span>Teste vue instalado</span>
    </div>
</template>

<script>
export default {
    name:'HomeEmpresa',
    created() {
        axios.get('/empresa/user')
            .then(r => {
                if (r.data) {
                    this.$store.commit('setEmpresa', r.data)
                }
            })
    }
}
</script>
