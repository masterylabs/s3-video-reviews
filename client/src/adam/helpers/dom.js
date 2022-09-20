const getCodeUrl = (code, na = '') => {
  const div = document.createElement('div')
  // const id = nanoid()
  // div.id = id
  div.style.display = 'none'

  document.body.appendChild(div)

  div.innerHTML = code
  //

  const links = div.getElementsByTagName('a')

  if (!links || !links.length) {
    div.remove()
    return na
  }

  const url = links[0].href

  // remove dom
  div.remove()

  return url
}

const getParent = (el, levels = 1, na = false) => {
  for (let i = 0; i < levels; i++) {
    if (!el.parentNode) {
      return na
    }
    el = el.parentNode
  }

  return el
}

const isFirstEl = (el) => {
  const container = getParent(el, 5)
  return !container.previousElementSibling
}

const isLastEl = (el) => {
  const container = getParent(el, 5)
  return !container.nextElementSibling
}

export { getCodeUrl, getParent, isFirstEl, isLastEl }
