export default {
  onDeleted() {},

  onSearch({ commit, dispatch }) {
    commit('SET_PAGE', 1)
    return dispatch('getItems')
  },

  onSearchBlur() {
    //
  },
}
