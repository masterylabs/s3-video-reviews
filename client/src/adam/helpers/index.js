export * from './str'
export * from './dom'
export * from './slugify'

const querySelectClassList = (e, na = []) => {
  const el = document.querySelector(e)
  return el ? [...el.classList] : na
}

const getThemePadding = () => {
  const mainList = querySelectClassList('.main-item-sheet')
  const pa = mainList.find((a) => a.indexOf('pa-') === 0)

  if (!pa) {
    return 0
  }
  return parseInt(pa.substring(3)) // + 3
}

const getMain = () => {
  const classList = querySelectClassList('.main-item-sheet')

  if (!classList) {
    return {}
  }

  const value = {}

  classList.forEach((item) => {
    const i = item.split('-')
    const key = i.shift()
    const val = i.pop()

    value[key] = val
  })

  return value
}

export { querySelectClassList, getThemePadding, getMain }
