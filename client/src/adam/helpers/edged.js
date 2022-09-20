import { getParent, getThemePadding, getMain } from '.'
import { isFirstEl, isLastEl } from './dom'

// let idCount = 0

const clearEdged = (el) => {
  const items = {
    el,
    parent: el.parentElement,
    col: getParent(el, 2),
  }

  const props = {
    el: ['edgedMb', 'edgedMt', 'edgedMb', 'edgedRounded'],
    parent: ['edgedMt', 'edgedMx', 'edgedMb'],
    col: ['edgedMt', 'edgedMb'],
  }

  for (const k in items) {
    const item = items[k]
    props[k].forEach((name) => {
      const value = item.dataset[name]

      if (value) {
        item.classList.remove(value)
      }
    })
  }
}

const makeEdged = (el) => {
  // if (!el.id) {
  //   idCount++
  //   el.setAttribute('id', `makeEdged${idCount}`)
  // }

  const parent = el.parentElement
  const spacer = {
    el: getParent(el, 4),
  }
  const padding = getThemePadding()
  const main = getMain()
  const isFirst = isFirstEl(el)
  const isLast = isLastEl(el)

  // remove x padding

  // margin X
  const mx = `mx-n${main.pa}`
  parent.classList.add(mx)
  parent.setAttribute('data-edged-mx', mx)

  if (isFirst) {
    const mt = `mt-n${padding}`
    const colParent = getParent(el, 2)
    colParent.setAttribute('data-edged-mt', mt)
    colParent.classList.add(mt)

    if (main.rounded) {
      const rounded = `rounded-t-${main.rounded}`
      el.setAttribute('data-edged-rounded', rounded)
      el.classList.add(rounded)
      el.style.overflow = 'hidden'
    }
  }

  if (isLast) {
    //
    const mb = `mb-n${main.pa}`
    const colParent = getParent(el, 2)
    colParent.setAttribute('data-edged-mb', mb)
    colParent.classList.add(mb)

    if (main.rounded) {
      const rounded = `rounded-b-${main.rounded}`
      el.setAttribute('data-edged-rounded', rounded)
      el.classList.add(rounded)
      el.style.overflow = 'hidden'
    }
  }

  spacer.classList = [...spacer.el.classList]

  spacer.mb = spacer.classList.find((a) => a.indexOf('mb-') === 0)

  if (spacer.mb) {
    spacer.value = spacer.mb.substring(3)
    el.classList.add(`mb-n${spacer.value}`)
    el.setAttribute('data-edged-mb', `mb-n${spacer.value}`)
  }
}

export { makeEdged, clearEdged }
