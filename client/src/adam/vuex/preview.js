import { findItem } from '../helpers/find'

const state = {}

const getters = {
  livePreviewData({ page, parent }) {
    // cleanse required for footer
    const data = JSON.parse(JSON.stringify(page))
    // advanced codes

    if (page.page_type !== 'offer') {
      const items = ['theme', 'bg', 'advanced']
      items.forEach((k) => {
        if (!page.opts[k]) {
          data[k] = parent[k]
        }
      })

      if (!page.opts.footer) {
        const pf = findItem(parent.body.children, 'footer', 'type')
        if (pf) {
          const parentFooter = { ...pf }
          const pageFooter = findItem(data.body.children, 'footer', 'type')

          if (pageFooter) {
            for (const k in parentFooter) {
              pageFooter[k] = parentFooter[k]
            }
          }
        }
      }
    }

    return {
      data,
    }
  },
}

const mutations = {}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions,
}
