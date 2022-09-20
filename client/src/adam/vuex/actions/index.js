import { createItem, createBoxedItem } from '../../helpers/create'

import adders from './adders'
import setters from './setters'
import loaders from './page'
import bucket from './bucket-actions'

export default {
  ...setters,
  ...adders,
  ...loaders,
  ...bucket,
  newPanelIndexCount({ commit, dispatch, state }, open = false) {
    const { newPanelIndex } = state

    commit('SET', { newPanelIndex: newPanelIndex + 1 })
    if (open) {
      dispatch('openNewPanelIndex')
    }
  },
  openNewPanelIndex({ commit, state }) {
    const { newPanelIndex } = state
    commit('SET', { panel: [newPanelIndex] })
  },

  removeBlock({ commit, state }, id) {
    commit('REMOVE', id)

    const { newPanelIndex } = state
    commit('SET', { newPanelIndex: newPanelIndex - 1 })
  },

  addBoxItem({ commit, state }, { id, type, children }) {
    if (type === 'links') {
      if (id === 'footer') {
        children = [
          createItem('btn', { textContent: 'Terms' }),
          createItem('btn', { textContent: 'Privacy' }),
          createItem('btn', { textContent: 'Disclaimer' }),
        ]
      } else {
        children = [
          createItem('btn', { textContent: 'Link 1' }),
          createItem('btn', { textContent: 'Link 2' }),
          createItem('btn', { textContent: 'Link 3' }),
        ]
      }
    }

    const item = createBoxedItem(state.page.body, type, children)

    commit('ADD_CHILD_SIMPLE', [id, item])
  },

  addChild({ commit, dispatch }, { id, type }) {
    if (type === 'links') {
      if (id === 'footer') {
        return dispatch('addFooterLinks', id)
      }
      return dispatch('addLinks', id)
    }
    commit('ADD_CHILD', { id, type })
  },

  addLinks({ commit }, id) {
    const children = [
      createItem('btn', { textContent: 'Link 1' }),
      createItem('btn', { textContent: 'Link 2' }),
      createItem('btn', { textContent: 'Link 3' }),
    ]

    commit('ADD_CHILD', { id, type: 'links', children })
  },

  addFooterLinks({ commit, state }, id) {
    const terms = createItem('btn', { textContent: 'Terms' })
    const privacy = createItem('btn', { textContent: 'Privacy' })
    const disclaimer = createItem('btn', { textContent: 'Disclaimer' })

    // const children = [terms, privacy, disclaimer]

    const links = createBoxedItem(state.page.body, 'links', [
      terms,
      privacy,
      disclaimer,
    ])

    commit('ADD_CHILD_SIMPLE', [id, links])
  },

  refreshPages({ commit, state }) {
    const refreshPages = !state.refreshPages
    commit('SET', { refreshPages })
  },

  destroy({ commit }) {
    commit('SET', {
      panel: [],
      page: null,
      parent: null,
      pageStr: '',
      removed: null,
      newPanelIndex: -1,
    })
  },
}
