import { reactive } from 'vue'

let idCount = 0

const state = reactive({
  body: {},
})

const appendId = (item) => {
  idCount++
  item._id = `_id-${idCount}`

  if (item.children) {
    for (let i = 0; i < item.children.length; i++) {
      item.children[i] = appendId(item.children[i])
    }
  }
  return item
}
const setBody = (body) => {
  state.body = appendId(body)
}

export { state, setBody }
