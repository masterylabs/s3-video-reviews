import config from '../../config'
import options from './options'

const Start = function(opts = null) {
  const elId = document.querySelector(`#${config.appId}`) ? config.appId : 'app'
  const el = document.querySelector(`#${elId}`)

  for (const k in el.dataset) config[k] = el.dataset[k]

  // append options to config
  for (const k in options)
    if (typeof config[k] == 'undefined') config[k] = options[k]

  // add base route
  if (config.route) {
    const i = config.route.split('/')
    i.pop()
    config.baseRoute = i.join('/')
  }

  if (opts) {
    for (const k in opts) {
      config[k] = opts[k]
    }
  }

  this.config = config

  // configure api
  this.setupApi()

  this.connectApi()
    .then((data) => this.onReady(data))
    .catch(({ response }) => this.onConnectError(response))
}

export default Start
