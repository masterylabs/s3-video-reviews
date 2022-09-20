import actions from './actions/index'
import mutations from './mutations'
import getters from './getters/getters'
import media from '../media/media'
import state from './state'
import preview from './preview'
import pages from '../pages/pages'

export default {
  namespaced: true,
  state: {
    ...state,
    ...media.state,
    ...preview.state,
    ...pages.state,
  },
  mutations: {
    ...mutations,
    ...media.mutations,
    ...preview.mutations,
    ...pages.mutations,
  },
  getters: {
    ...getters,
    ...media.getters,
    ...preview.getters,
    ...pages.getters,
  },
  actions: {
    ...actions,
    ...media.actions,
    ...preview.actions,
    ...pages.actions,
  },
}
