/**
 * Use:
 * import {createPage} from '../helpers/create'
 */

import { nanoid } from 'nanoid'
import pageTemplate from '../templates/page'
import items from '../templates/items'
import { jsonClense } from './obj'

const cloneNewId = (item) => {
  // if (Array.isArray(item)) {
  //   for (let i = 0; i < item.length; i++) {
  //     item[i] = cloneNewId(item[i])
  //   }
  //   return item
  // }

  if (item.id) item.id = nanoid()

  if (item.children && Array.isArray(item.children)) {
    for (let i = 0; i < item.children.length; i++) {
      item.children[i] = cloneNewId(item.children[i])
    }
  }

  return item
}

export const createClone = (fromItem, args = {}) => {
  return cloneNewId(JSON.parse(JSON.stringify({ ...fromItem, ...args })))
}

// may need to clenseClonse
export const createPage = (name = 'Page', args = {}) => {
  return { ...pageTemplate, name, id: null, ...args }
}

export const createItem = (type, args = {}) => {
  const name = items[type].name || null

  const base = items[type] ? jsonClense(items[type]) : {}

  if (!base.props) base.props = {}

  if (args.props) {
    base.props = { ...base.props, ...args.props }
    delete args.props
  }

  if (!base.opts) base.opts = {}

  if (args.opts) {
    base.opts = { ...base.opts, ...args.opts }
    delete args.opts
  }

  const item = {
    type,
    name,
    children: null,
    timed: null,
    ...base,
    ...args,
    id: nanoid(),
    disabled: false,
  }

  return item
}

export const createBlockItem = (type, name = '', args = null) => {
  if (!name) name = type

  if (args) {
    args = jsonClense(args)
  } else {
    args = {}
  }

  const item = createItem(type, args)
  const block = createItem('block', { name })
  const box = createItem('box', { name })
  box.children = [item]
  block.children = [box]
  return block
}

export const createPageBoilderplate = (args, children = null) => {
  const page = createPage(args.name, args)

  const footer = createItem('footer')

  const main = createItem('main')

  const section = createItem('section')

  if (!children) {
    const block = createItem('block')
    section.children = [block]
  } else {
    section.children = Array.isArray(children) ? children : [children]
  }

  main.children = [section]

  page.body.children = [main, footer]

  return page
}

export const createRowItem = (args) => {
  const item = createItem(args)

  const col = createItem('col')

  const sheet = createItem('sheet')

  sheet.children = [item]
  col.children = [sheet]

  return col
}

export const createBoxedItem = (body, type, children = null) => {
  const box = createItem('box')
  const item = createItem(type)

  if (children) {
    item.children = children
  }

  box.children = [item]

  return box
}
