import axios from 'axios'

let api = null

const createApi = (baseURL, config = {}) => {
  const headers = {
    'Content-Type': 'application/x-www-form-urlencoded',
    // Accept: 'application/json',
  }

  api = axios.create({
    baseURL,
    headers,
  })

  api.interceptors.request.use((req) => {
    if (!req.params) req.params = {}

    if (config.authToken) {
      req.params.auth_token = config.authToken
    }

    // cache buster
    req.params.mlcabu = Date.now()

    return req
  })

  //
}

function setAuthHeader() {
  // if (!api.defaults.params) {
  //   api.defaults.params = {}
  // }
  // api.defaults.params['auth-token'] = token
  //
}

function get(url = '', params = null, noMessage = false) {
  //
  return api
    .get(url, { params })
    .then((res) => this._apiResponseHandler(res, noMessage))
    .catch((e) => this._apiErrorResponseHandler(e, noMessage))
}

async function bgPost(url = '', data = {}, params = null, ignore = null) {
  return this.post(url, data, params, ignore, true)
}

async function post(
  url = '',
  data = {},
  params = null,
  ignore = null,
  noMessage = false
) {
  const form = new URLSearchParams()

  data = { ...data }

  for (const k in data) {
    if (ignore && ignore.includes(k)) continue

    if (data[k] === null) {
      continue
    }

    if (typeof data[k] == 'boolean') {
      data[k] = data[k] ? 1 : 0
    } else if (Array.isArray(data[k])) {
      data[k] = JSON.stringify(data[k])
    } else if (typeof data[k] == 'object') {
      data[k] = JSON.stringify(data[k])
    }
    form.append(k, data[k])
  }

  return api
    .post(url, form, { params })
    .then((res) => this._apiResponseHandler(res, noMessage))
    .catch((e) => this._apiErrorResponseHandler(e, noMessage))
}

/**
 * Valid Response Handler
 */

function _apiResponseHandler(res, noMessage = false) {
  if (noMessage) {
    return res.data || res
  }
  if (res.data && res.data.message) {
    if (res.data.success) {
      this.success(res.data.message)
    } else {
      this.message(res.data.message)
    }
  }

  return res.data || res
}

function _apiErrorResponseHandler(e, noMessage = false) {
  if (noMessage) {
    return e
  }
  if (e.response) {
    this.apiError = e.response
    if (e.response.data && e.response.data.message) {
      this.error(e.response.data.message)
    }
  } else {
    this.apiError = 'Unable to connect'
  }
}

function _apiBeforeRequest() {
  if (this.apiResponse) delete this.apiResponse
  if (this.apiError) delete this.apiError
}

export { createApi }

export default {
  get,
  post,
  bgPost,
  setAuthHeader,
  _apiBeforeRequest,
  _apiResponseHandler,
  _apiErrorResponseHandler,
}
