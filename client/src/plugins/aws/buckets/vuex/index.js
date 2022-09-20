import folder from '../folder/vuex'
import bucket from '../bucket/vuex'
import mutations from './mutations'
import actions from './actions/actions'
import getters from './getters'
import state from './state'
import website from '../website/vuex'
import fileEditor from '../file-editor/vuex'

const baseState = {
  ...state,
  ...folder.state,
  ...bucket.state,
  ...website.state,
}

export { baseState }

export default {
  namespaced: true,
  state: {
    ...baseState,
  },
  getters: {
    ...getters,
    ...folder.getters,
    ...bucket.getters,
    ...website.getters,
  },
  mutations: {
    ...mutations,
    ...folder.mutations,
    ...bucket.mutations,
    ...website.mutations,
  },
  actions: {
    ...actions,
    ...folder.actions,
    ...bucket.actions,
    ...website.actions,
    ...fileEditor.actions,
  },
}
