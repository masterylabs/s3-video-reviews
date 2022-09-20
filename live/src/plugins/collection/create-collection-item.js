import { reactive, computed } from 'vue'
// import { useRoute, useRouter } from 'vue-router'
import { get, post } from '@/plugins'

const createCollectionItem = (opts = {}, stateAppend = {}) => {
  if (typeof opts === 'string') {
    opts = {
      endpoint: `/${opts}`,
    }
  }

  const state = reactive({
    ready: false,
    loading: false,
    endpoint: opts.endpoint, // '/products',
    data: {},
    dataStr: '',
    ...stateAppend,
  })

  const item = computed(() => state.data)

  const load = async (id) => {
    const res = await get(`${state.endpoint}/${id}`)

    if (!res) {
      return false
    }

    if (opts.onLoad) {
      opts.onLoad({ state, id, data: res.data })
    }

    state.data = res.data
    state.dataStr = JSON.stringify(res.data)
    state.ready = true

    return true
  }

  const save = async () => {
    state.loading = true
    const formData = { ...state.data }
    const endpoint = formData.id
      ? `${state.endpoint}/${formData.id}`
      : state.endpoint
    const res = await post(endpoint, formData)
    if (res) {
      state.data = res.data
      state.dataStr = JSON.stringify(res.data)
    }
    state.loading = false
    // return true or false
    return !!res
  }

  const create = async (data) => {
    state.creating = true

    // return
    const res = await post(state.endpoint, data)
    state.creating = false
    return res ? res.data : false
  }

  const deleteItem = async (opts = {}) => {
    state.deleting = true
    const id = opts.id || state.data.id

    const res = await post(`${state.endpoint}/${id}/delete`)

    return !!res
  }

  const hasChanges = computed(
    () => state.ready && state.dataStr !== JSON.stringify(state.data)
  )

  const clearItem = () => {
    state.ready = false
    state.data = {}
    state.dataStr = ''
  }

  // const loadRoute = async (paramKey = 'id') => {
  //   console.log('[create-collection-item] loadRoute')
  //   // useRoute, useRouter
  //   const route = useRoute()
  //   const router = useRouter()

  //   const res = await load(route.params[paramKey])

  //   if (!res) {
  //     router.push({ path: state.endpoint, replace: true })
  //   }

  //   return res
  // }

  // save should be update, same as collection, deleteItem should be destroy

  return {
    state,
    item,
    hasChanges,
    load,
    loadItem: load,
    // loadRoute,
    save,
    create,
    deleteItem,
    clearItem,
  }
}

export { createCollectionItem }
