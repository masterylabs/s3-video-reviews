const pagesTemplate = {
  ready: false,
  itemsCount: 0,
  loading: {
    items: false,
    thanks: false,
    oto: false,
  },
  form: {
    page: 1,
    q: '',
    limit: 12,
    // order: 'DESC',
    // orderBy: 'id',
  },

  items: {
    data: [],
    pagin: {
      total: 0,
      page: 1,
      pages: 1,
      perpage: 100,
    },
  },
}
const state = {
  pages: {
    ...pagesTemplate,
    // ready: false,
    // itemsCount: 0,
    // loading: {
    //   items: false,
    //   thanks: false,
    //   oto: false,
    // },
    // form: {
    //   page: 1,
    //   q: '',
    //   limit: 12,
    //   // order: 'DESC',
    //   // orderBy: 'id',
    // },

    // items: {
    //   data: [],
    //   pagin: {
    //     total: 0,
    //     page: 1,
    //     pages: 1,
    //     perpage: 100,
    //   },
    // },
  },
}

const mutations = {
  CLEAR_PAGES(state) {
    state.pages = { ...pagesTemplate }
  },
}

const getters = {
  pages({ pages }) {
    return pages
  },

  pagesWithChanges({ pages }, { changes, hasChanges, isOffer }) {
    if (!isOffer || !hasChanges) {
      return []
    }

    const offerPages = pages.items.data
    const value = []

    for (const key in changes) {
      if (!changes[key]) continue
      const items = offerPages.filter(({ opts }) => !opts[key])
      if (!items.length) continue

      items.forEach(({ id, slug }) => {
        const index = value.findIndex((v) => v.id === id)
        if (index < 0) {
          value.push({ id, slug })
        }
      })
    }

    return value
  },
}

const actions = {
  //
}

export default {
  state,
  getters,
  mutations,
  actions,
}
