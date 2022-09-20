export const getFileName = (file) => {
  return file.split('/').pop().split('.')[0]
}

export const parseConfigVal = (val) => {
  if (['1', 'true'].includes(val)) return true
  if (['0', 'false'].includes(val)) return false

  return val
}

export const loadContext = (
  Vue,
  context,
  prefix = '',
  append = '',
  checkRootComp = true,
  checkRootMatch = false
) => {
  if (typeof context == 'function') {
    context = [context]
  }

  context.forEach((context) => {
    context.keys().forEach((fileName) => {
      const componentConfig = context(fileName)
      const componentName = fileName
        .replace(/^\.\/_/, '')
        .replace(/\.\w+$/, '')
        .split('-')
        .map((kebab) => kebab.charAt(0).toUpperCase() + kebab.slice(1))
        .join('')
        .split('/')
        .pop()

      if (checkRootMatch && componentName.indexOf(prefix) === 0) {
        Vue.component(componentName, componentConfig.default || componentConfig)
      } else if (checkRootComp && componentName == prefix) {
        Vue.component(componentName, componentConfig.default || componentConfig)
      } else {
        let name = ''
        if (componentName.toLowerCase() === 'index') {
          name = prefix + append
        } else {
          name = prefix + componentName + append
        }

        //

        Vue.component(name, componentConfig.default || componentConfig)
      }
    })
  })
}

// Vue App, Compsonents object or array, prefix
export const loadComponents = (app, items, prefix = 'M') => {
  if (!Array.isArray(items)) {
    items = [items]
  }

  items.forEach((item) => {
    app.component(prefix + getFileName(item.__file), item)
  })
}

export const getConfig = (selector = '#app', config = {}) => {
  const el = document.querySelector(selector)
  if (el) {
    for (const k in el.dataset) config[k] = parseConfigVal(el.dataset[k])
  }

  return config
}

export const registerContext = (app, arr) => {
  arr.forEach((c) => {
    const prepend = c.prepend || 'm'
    //
    loadComponents(app, c.context, prepend)
  })
}

export const registerComponents = (app, prefix, items) => {
  items.forEach((comp) => {
    const name = prefix + comp.__file.split('/').pop().split('.')[0]
    app.component(name, comp)
  })
}
