const state = {
  dragItem: -1,
  dragOver: -1,
  groupId: 'drag-group',
}

const mutations = {
  SET(state, payload) {
    for (const k in payload) {
      state[k] = payload[k]
    }
  },
}

const getters = {
  dragItem({ dragItem }) {
    return dragItem
  },
  dragOver({ dragOver }) {
    return dragOver
  },
  groupId({ groupId }) {
    return groupId
  },
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
}
