import { useRoute, useRouter } from 'vue-router'
import { get, post } from '@/plugins'

const createStoreItem = (item) => {
  const loadItem = async (opts = {}) => {
    const route = useRoute()
    const router = useRouter()

    const id = opts.id || route.params.id
    const res = await get(`${item.endpoint}/${id}`)

    if (!res) {
      router.push({ path: item.endpoint, replace: true })
      return opts.onError ? opts.onError() : false
    }

    item.data = res.data
    item.str = JSON.stringify(item.data)
    item.ready = true
  }

  const saveItem = async () => {
    item.loading = true
    const formData = { ...item.data }
    const endpoint = formData.id
      ? `${item.endpoint}/${formData.id}`
      : item.endpoint

    const res = await post(endpoint, formData)

    if (res) {
      item.data = res.data
      item.str = JSON.stringify(res.data)
    }

    item.loading = false

    // return true or false
    return !!res
  }

  const deleteItem = async (opts = {}) => {
    item.deleting = true
    const id = opts.id || item.data.id

    const res = await post(`${item.endpoint}/${id}/delete`)
  }

  return {
    loadItem,
    saveItem,
    deleteItem,
  }
}

export {} //createStoreItem
