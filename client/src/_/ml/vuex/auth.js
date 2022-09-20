export default {
  getters: {
    authenticated(state) {
      return state.data.license && state.data.license.value ? true : false
    },
  },
}
