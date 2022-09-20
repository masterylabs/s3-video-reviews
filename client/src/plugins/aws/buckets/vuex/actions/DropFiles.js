import { getDataTransferItems } from '../../helpers'

export default {
  onDropFiles({ dispatch }, files) {
    // const items = []
    for (const k in files) {
      if (typeof files[k] === 'object') {
        dispatch('queUpload', files[k])
      }
    }
  },

  // introduction to support directory structure drops
  async onDataTransfer({ dispatch }, dataTransfer) {
    const items = await getDataTransferItems(dataTransfer.items)

    dispatch('_processDataTransferItems', items)
  },

  _processDataTransferItems({ dispatch }, items) {
    for (const k in items) {
      // validate

      if (typeof items[k] !== 'object') {
        continue
      }

      const item = items[k]

      const isHidden = item.name.charAt(0) === '.'
      // const fullFileName = item._dirPath + item.name

      // skip hidden files

      if (isHidden) {
        continue
      }

      // que upload
      dispatch('queUpload', item)

      if (item._isDir && item.children && item.children.length) {
        dispatch('_processDataTransferItems', item.children)
      }
    }
  },
}
