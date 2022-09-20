import EventsBaseClass from '@/plugins/helpers/EventsBaseClass'

const parseStyleNumber = (value) => {
  return !isNaN(value) ? `${value}px` : value
}

class WindowFrame extends EventsBaseClass {
  mounted = false
  w = null

  _scriptQue = []

  // string or element, options
  constructor(container, options = {}) {
    super()

    if (typeof container === 'string') {
      container = document.querySelector(container)
    }

    this.container = container
    this.options = options

    this.id = options.id || 'WindowFrame'
    this.iframe = document.createElement('iframe')
    this.iframe.style.border = 'none'

    window[this._getCallbackName()] = (w) => {
      this.w = w
      this.doc = w.document
      this.body = w.document.querySelector('body')
      this.body.style.padding = 0
      this.body.style.margin = 0

      // load script
      if (this._scriptQue.length) {
        this._scriptQue.forEach(({ src, options }) => {
          this._loadScript(src, options)
        })
      }

      this.call('ready')
    }
  }

  addScript(src, options = {}) {
    if (this.mounted) {
      this._loadScript(src, options)
    } else {
      this._scriptQue.push({ src, options })
    }
  }

  addStyle(cssStr) {
    const head = this.doc.head || this.doc.getElementsByTagName('head')[0]
    const style = this.doc.createElement('style')
    head.appendChild(style)
    style.type = 'text/css'
    style.appendChild(document.createTextNode(cssStr))
    // alert('added style')
    //
  }

  // provisional method
  createDiv(id) {
    const div = document.createElement('div')
    div.id = id
    this.body.appendChild(div)
    return this
  }

  mount() {
    const cb = this._getCallbackName()
    const html = `<body onload="parent.${cb}(this.window)"></body>`
    const iframe = this.iframe
    iframe.style['vertical-align'] = 'bottom'

    this.container.appendChild(iframe)
    iframe.contentWindow.document.open()
    iframe.contentWindow.document.write(html)
    iframe.contentWindow.document.close()
  }

  _getCallbackName() {
    return `windowFrame${this.id}CallbackFunc`
  }

  set width(value) {
    this.iframe.style.width = parseStyleNumber(value)
  }

  set height(value) {
    this.iframe.style.height = parseStyleNumber(value)
  }

  _loadScript(src) {
    // const doc = this.w.document
    const script = this.doc.createElement('script')
    script.src = src
    script.onload = (e) => {
      this.call('script-loaded', e)
    }
    this.doc.getElementsByTagName('head')[0].appendChild(script)
  }

  // loading(value) {
  //   const div = document.createElement('div')
  //   div.style.position = 'absolute'
  //   div.style.left = 0
  //   div.style.top = '50%'
  //   div.style.width = '100%'
  //   div.style.height = '20px'
  //   div.style.backgroundColor = 'rgba(255,0,0,0.5)'
  //   div.style.zIndex = 1000
  //   this.body.appendChild(div)
  // }
}

export default WindowFrame
