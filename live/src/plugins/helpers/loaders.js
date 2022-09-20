const loadComponents = (app, components, prefix = '') => {
  if (!Array.isArray(components)) {
    components = [components]
  }

  components.forEach((components) => {
    Object.entries(components).forEach(([path, definition]) => {
      const componentName =
        prefix +
        path
          .split('/')
          .pop()
          .replace(/\.\w+$/, '')

      // Register component on this Vue instance
      app.component(componentName, definition.default)
    })
  })
}

export { loadComponents }
