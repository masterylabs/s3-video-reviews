export default {
  SET(state, payload) {
    for (const k in payload) {
      state[k] = payload[k]
    }
  },
  SET_PAGE(state, n) {
    state.query.page = n
  },

  REMOVE_ITEM(state, index) {
    state.data.splice(index, 1)
    state.pagin.total--
  },

  UPDATE_ITEM(state, { index, value }) {
    state.data[index] = { ...value }
  },
}
