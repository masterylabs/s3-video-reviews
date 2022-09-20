import { reactive, computed } from 'vue'
import { get } from '@/plugins'

// options: state, searchFilter

const stateTemplate = (opts = {}) => {
  if (typeof opts === 'string') {
    opts = {
      endpoint: `/${opts}`,
    }
  }

  return {
    ready: false,
    loading: false,
    searching: false,
    // endpoint: opts.endpoint, // '/products',
    query: {
      q: '',
      page: 1,
      limit: 9,
    },
    data: [],
    pagin: {
      total: 0,
    },
    ...opts,
  }
}

const createCollection = (opts = {}) => {
  if (typeof opts === 'string') {
    opts = {
      endpoint: `/${opts}`,
    }
  }

  if (!opts.state) {
    console.log('reactive', opts.endpoint)
  }

  // can pass in a state
  const state = opts.state
    ? opts.state
    : reactive({
        ready: false,
        loading: false,
        searching: false,
        endpoint: opts.endpoint, // '/products',
        query: {
          q: '',
          page: 1,
          limit: 9,
        },
        data: [],
        pagin: {
          total: 0,
        },
      })

  // const searchFilter = opts.searchFilter ||

  const items = computed(() => {
    if (!state.query.q) {
      return state.data
    }

    const q = state.query.q.toLowerCase()

    if (opts.searchFilter) {
      return state.data.filter(opts.searchFilter)
    }

    return state.data.filter((item) => {
      for (const k in item) {
        if (
          typeof item[k] === 'string' &&
          item[k].toLowerCase().indexOf(q) > -1
        ) {
          return true
        }
      }
      return false
    })
  })

  const getItems = async () => {
    state.loading = true
    const res = await get(state.endpoint, state.query)

    state.data = res.data
    state.pagin = res.pagin
    state.loading = false
  }

  const refresh = () => {
    state.query.page = 1
    state.query.q = ''
    getItems()
  }

  const loadItems = async () => {
    await getItems()
    state.ready = true
  }

  const search = async () => {
    state.searching = true
    await getItems()
    state.searching = false
  }

  const onPagin = getItems

  const addItem = (item) => {
    console.log('addItem', item)
    state.data.push(item)
    state.pagin.total++
  }
  const removeItem = (id) => {
    const index = state.data.findIndex((item) => item.id === id)
    if (index > -1) {
      state.data.splice(index, 1)
    }
    state.pagin.total--
  }

  // loadItems()

  return {
    state,
    items,
    onPagin,
    search,
    load: loadItems,
    addItem,
    removeItem,
    refresh,
  }
}

export { createCollection, stateTemplate }
