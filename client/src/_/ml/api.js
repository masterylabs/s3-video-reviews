import axios from 'axios'

const getLocalAppConfig = () => {
  if (
    window.ML_USE_LOCAL_APP_CONFIG
    // &&  window.location.href.indexOf('http://localhost:') === 0
  ) {
    return window.ML_USE_LOCAL_APP_CONFIG
  }
  return false
}

const setupApi = function() {
  // no cachsbuster for local dev
  if (document.location.host.indexOf('localhost:') > -1)
    this.config.cacheBuster = false

  const baseURL = this.getApiUrl()

  const headers = {
    'Content-Type': 'application/x-www-form-urlencoded',
    Accept: 'application/json',
  }

  if (this.config.token) headers.Authorization = this.config.token

  const igorePostFields = this.config.apiPostIgnoreFields

  const Axios = axios.create({
    baseURL,
    headers,
  })

  Axios.interceptors.request.use((req) => {
    if (!req.params) req.params = {}
    // secondary
    if (this.config.useUrlAuthToken) req.params.auth_token = this.config.token
    // cachbuster
    if (this.config.cacheBuster) req.params.mlcabu = Date.now()

    return req
  })

  // API GET (success & error messages handled automatically, find in events)

  this.get = (endpoint = '', params = {}) =>
    Axios.get(endpoint, { params })
      .then(({ data }) => {
        this.apiSuccessHandler(data)
        return data
      })
      .catch(({ response }) => {
        this.apiErrorHander(response)
        return false
      })

  // API POST (success & error messages handled automatically, find in events)

  this.postOnly = (endpoint = '', data = {}, params = {}) => {
    return this.post(endpoint, data, params, true)
  }

  this.post = (
    endpoint = '',
    data = {},
    params = {},
    noSuccess = false,
    noError = false
  ) => {
    const form = new URLSearchParams()
    data = { ...data }
    for (const k in data) {
      if (igorePostFields.includes(k)) continue

      if (data[k] === null) {
        continue
      }

      if (typeof data[k] == 'boolean') data[k] = data[k] ? 1 : 0
      else if (typeof data[k] == 'object') data[k] = JSON.stringify(data[k])
      form.append(k, data[k])
    }

    return Axios.post(endpoint, form, { params })
      .then(({ data }) => {
        if (!noSuccess) this.apiSuccessHandler(data)
        return data
      })
      .catch(({ response }) => {
        if (!noError) this.apiErrorHander(response)
        return false // response.data
      })
  }

  /**
   *
   * API Resposne Handlers
   */

  this.apiSuccessHandler = (data) => {
    if (data.message) this.success(data.message)
  }

  this.apiErrorHander = (response) => {
    if (response.data && response.data.message) {
      this.error(response.data.message, response.data.status)
    }
  }

  /**
   * Collect to app, check if url api is required
   */

  this.connectApi = (endpoint = 'app') =>
    new Promise((resolve, reject) => {
      const localConfig = getLocalAppConfig()

      if (localConfig) {
        return resolve(localConfig)
      }

      const connect = () => {
        Axios.get(endpoint)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((e) => {
            if (this.config.useUrlAuthToken) return reject(e)
            this.config.useUrlAuthToken = true
            connect()
          })
      }
      connect()
    })

  this.remote = Axios
}

export default {
  setupApi,
}
