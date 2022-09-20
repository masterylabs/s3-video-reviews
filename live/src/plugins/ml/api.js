import axios from 'axios'

const dataset = document.querySelector('#app').dataset
const api = axios.create({
  // withCredentials: false,
  // crossdomain: true,
  baseURL: dataset.api,
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    // Accept: 'application/json',
    // 'Access-Control-Allow-Origin': '*',
  },
})

const postIgnores = ['id', 'identifier', 'created', 'updated']

const authToken = dataset.token

api.interceptors.request.use((req) => {
  if (!req.params) req.params = {}

  if (authToken) {
    req.params.auth_token = authToken
  }

  // cache buster
  // req.params.ml_cbu = Date.now()

  return req
})

// const get = api.get
const get = async (endpoint, params = {}) => {
  try {
    const res = await api.get(endpoint, { params }) //.then(({ data }) => data)

    return res.data
  } catch (err) {
    return false
  }
}

const post = async (endpoint, data = {}) => {
  const form = new URLSearchParams()

  // data = { ...data }

  // return

  for (const k in data) {
    // strip invalid values
    if ((postIgnores && postIgnores.includes(k)) || data[k] === null) continue

    // parse values
    if (typeof data[k] == 'boolean') {
      form.append(k, data[k] ? 1 : 0)
    } else if (typeof data[k] == 'object') {
      form.append(k, JSON.stringify(data[k]))
    } else {
      form.append(k, data[k])
    }
  }

  try {
    const { data } = await api.post(endpoint, form)
    return data
  } catch (err) {
    return false
  }
}

export { api, get, post }
