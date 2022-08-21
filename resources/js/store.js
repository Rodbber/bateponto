import { createStore } from 'vuex'

// Create a new store instance.
export default createStore({
  state () {
    return {
      empresa: null
    }
  },
  mutations: {
    setEmpresa (state, payload) {
      state.empresa = payload;
    }
  }
})
