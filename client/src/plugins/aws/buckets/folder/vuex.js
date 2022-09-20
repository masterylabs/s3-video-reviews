const state = {
  folder: {
    dialog: false,
    step: 1,
    Key: '',
    form: {
      name: '',
      meta: {
        icon: 'folder',
        color: '',
      },
      is_public: false,
    },
  },
}

const getters = {
  folder({ folder }) {
    return folder
  },
}

const mutations = {
  CLEAR_FOLDER_FORM({ folder }) {
    folder.step = 1
    folder.form.name = ''
    folder.form.meta.icon = 'folder'
    folder.form.meta.color = ''
  },
}

const actions = {
  clearFolderForm({ commit }) {
    commit('CLEAR_FOLDER_FORM')
  },
}

export default { state, getters, mutations, actions }
