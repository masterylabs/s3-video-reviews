export default {
  async load({ commit }, endpoint) {
    // commit('SET', { endpoint })
    const req = await this._vm.$app.get(endpoint)

    if (!req || !req.data) {
      return false // invalid
    }

    if (req.parent) {
      commit('SET', { parent: req.parent })
    }

    const pageStr = JSON.stringify(req.data)

    commit('SET', { page: req.data, pageStr, savedSlug: req.data.slug })

    return true
  },

  async save({ commit, state: { page }, getters: { endpoint }, dispatch }) {
    // return
    const pageStr = JSON.stringify(page)
    // bucket must be saved first
    await this._vm.$app.bgPost(endpoint, { ...page })

    await dispatch('saveBucket')

    if (page.page_type === 'offer') {
      await dispatch('saveOfferPages')
    }

    commit('SET', { pageStr, savedSlug: page.slug })

    this._vm.$app.success('Saved!')
  },

  async saveOfferPages({ dispatch, getters: { pagesWithChanges } }) {
    const bucket = await dispatch('getBucket')

    if (!pagesWithChanges.length) return

    return new Promise((resolve) => {
      const saveNext = async (index) => {
        const item = pagesWithChanges[index]

        await dispatch('savePageBucket', {
          pageId: item.id,
          slug: item.slug,
          bucket,
        })

        index++
        if (pagesWithChanges.length > index) {
          return saveNext(index)
        }
        resolve()
      }

      saveNext(0)
    })
  },
}
