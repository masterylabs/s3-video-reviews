import { findItem, findParent } from '../helpers/find'
import { createItem, createClone } from '../helpers/create'
import { arrayMoveImmutable as arrayMove } from 'array-move'

export default {
  // v3

  RESTORE_REMOVED({ removed, page }) {
    const item = { ...removed.item }
    const parent = findItem(page.body, removed.parentId)
    parent.children.splice(removed.index, 0, item)
    removed = null
  },

  SET_PAGE_PROP(state, payload) {
    for (const k in payload) state.page[k] = payload[k]
  },

  ADD_SECTION_ITEM(state, [id, type, name = null]) {
    const section = findItem(state.page.body, id)
    const item = createItem(type)

    if (!name) {
      name = item.name || type
    }

    const block = createItem('block', { name })
    const box = createItem('box')

    box.children = [item]
    block.children = [box]
    section.children.push(block)
  },

  ADD_BOX_ITEM({ page }, { id, type }) {
    const parent = findItem(page.body, id)
    const box = createItem('box')
    const item = createItem(type)

    box.children = [item]

    if (!parent.children) parent.children = []

    parent.children.push(box)
  },

  MOVE_PARENT_UP({ page }, id) {
    const parent = findParent(page.body, id)
    const index = parent.children.findIndex((child) => child.id === id)
    parent.children = arrayMove(parent.children, index, index - 1)
  },

  MOVE_UP({ page }, id) {
    const parent = findParent(page.body, id)
    const index = parent.children.findIndex((child) => child.id === id)
    parent.children = arrayMove(parent.children, index, index - 1)
  },

  MOVE_DOWN({ page }, id) {
    const parent = findParent(page.body, id)
    const index = parent.children.findIndex((child) => child.id === id)
    parent.children = arrayMove(parent.children, index, index + 1)
  },

  ADD_CHILD_SIMPLE({ page }, [parentId, child]) {
    const parent = findItem(page.body, parentId)
    if (!parent.children) {
      parent.children = []
    }
    parent.children.push(child)
  },

  ADD_CHILD({ page }, { id, type, children }) {
    const parent = findItem(page.body, id)
    const child = createItem(type)

    if (children) {
      child.children = Array.isArray(children) ? children : [children]
    }

    if (!parent.children) parent.children = []
    parent.children.push(child)
  },

  CLONE(state, id) {
    const parent = findParent(state.page.body, id)
    const index = parent.children.findIndex((item) => item.id === id)
    const clone = createClone(parent.children[index])
    parent.children.splice(index + 1, 0, clone)
  },

  //
  SET(state, payload) {
    for (const k in payload) state[k] = payload[k]
  },

  REMOVE(state, id) {
    const parent = findParent(state.page.body, id)
    const index = parent.children.findIndex((child) => child.id === id)
    // need this for panelss (SectionalPanel)
    state.removed = {
      parentId: parent.id,
      index,
      item: { ...parent.children[index] },
    }

    parent.children.splice(index, 1)
  },

  // [parentId, childItem]
  APPEND_CHILD(state, arr) {
    const item = findItem(state.page.body, arr[0])
    if (!item.children) item.children = []
    item.children.push(arr[1])
  },
  // arr: [id, 1]
  MOVE(state, arr) {
    const parent = findParent(state.page.body, arr[0])
    const index = parent.children.findIndex((child) => child.id === arr[0])
    parent.children = arrayMove(parent.children, index, index + arr[1])
  },

  // ROWS

  ADD_ROW(state) {
    const main = findItem(state.page.body, 'main', 'type')
    const row = createItem('row')

    // to support sheet and other chil
    if (main.children.length === 1 && main.children[0].type !== 'row') {
      main.children[0].children.push(row)
    } else {
      main.children.push(row)
    }
  },

  REMOVE_ROWS(state) {
    const parent = findParent(state.page.body, 'row', 'type')
    parent.children = []
  },
}
