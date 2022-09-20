import { createItem, createBoxedItem, createClone } from '../../helpers/create'

import { findItem } from '../../helpers/find'

const mergeBaseValues = (a, b) => {
  for (const k in b) {
    if (b[k] && typeof b[k] !== 'object') {
      a[k] = b[k]
    }
  }
  return a
}

export default {
  async addOffer(_, { offer, video, template }) {
    if (!template) template = 'offer'
    // return
    const page = await this._vm.$app.get(`templates/${template}`)

    const pageVideo = mergeBaseValues(
      findItem(page.body, 'video', 'type'),
      video
    )

    pageVideo.props = mergeBaseValues(pageVideo.props, video.props)

    for (const k in offer) {
      if (offer[k]) {
        page[k] = offer[k]
      }
    }

    const { data } = await this._vm.$app.post('pages', page)

    return data
  },

  async addOfferPage({ state, dispatch }, name) {
    const page = await this._vm.$app.get(`templates/${name}`)
    page.parent_id = state.page.id
    const res = await this._vm.$app.post(`pages`, page)

    const pageId = res.data.id
    const slug = res.data.slug

    // bucket
    const { data } = await this._vm.$app.get(`/pages/${pageId}/files/index`)
    const bucket = await dispatch('getBucket')

    const file = new Blob([data.contents], { type: data.type })

    const uploaded = await bucket.uploadObject({
      Key: slug,
      file,
    })
  },

  async addThanksPage({ dispatch }) {
    return await dispatch('addOfferPage', 'thanks')
  },
  async addOtoPage({ dispatch }) {
    return await dispatch('addOfferPage', 'oto')
  },

  async addLegalPage({ dispatch }) {
    return await dispatch('addOfferPage', 'legal')
  },

  async addSectionUpgrade({ commit, dispatch }, id) {
    const block = await this._vm.$app.get(`templates/upgrade`)
    commit('ADD_CHILD_SIMPLE', [id, createClone(block)])
    dispatch('newPanelIndexCount', true)
  },

  addSectionItem({ commit, state, dispatch }, { id, type, children, name }) {
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

    if (!name) {
      name = type
    }

    const block = createItem('block', { name })
    const box = createBoxedItem(state.page.body, type, children)
    block.children = [box]

    commit('ADD_CHILD_SIMPLE', [id, block])

    dispatch('newPanelIndexCount', true)
  },
}
