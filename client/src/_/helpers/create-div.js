import { nanoid } from 'nanoid'

export const createDiv = (
  selector = '',
  style = {},
  content = null,
  tag = 'div'
) => {
  const el = document.createElement(tag)

  if (selector) {
    if (typeof selector == 'boolean') {
      el.id = nanoid()
    } else if (selector.indexOf('.') === 0) {
      el.classList.add(selector.substring(1))
    } else {
      el.id = selector.substring(1)
    }
  }

  for (const k in style) el.style[k] = style[k]

  if (content) el.innerHTML = content

  document.body.appendChild(el)

  return el
}

export const createVideo = (selector = '', style = {}) => {
  return createDiv(selector, style, null, 'video')
}

export const createHiddenDiv = (selector = '', style = {}, content = null) => {
  style = {
    position: 'fixed',
    left: '-201px',
    top: '0px',
    width: '200px',
    height: '200px',
    overflow: 'hidden',
    ...style,
  }
  return createDiv(selector, style, content)
}
