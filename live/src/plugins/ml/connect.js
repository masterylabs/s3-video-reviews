import { get } from './api'
import { loadStore } from '@/store'

const connect = async (endpoint = '/admin') => {
  const data = await get(endpoint)

  if (!data) {
    return false
  }

  //

  // load data
  loadStore({ ...data.data, connected: true })

  return true
}

export { connect }
