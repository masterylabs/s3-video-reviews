// const mapPreview = (item, parent = {}) => {
//   item = { ...item }
//   if (parent.childProps) {
//     if (parent.childProps.color && !item.props.color) {
//       item.props.color = parent.childProps.color
//     }
//     // item.props.color = 'blue'
//   }

//   if (item.children && Array.isArray(item.children)) {
//     item.children.forEach((child, i) => {
//       item.children[i] = mapPreview(child, item)
//     })
//   }
//   return item
// }

export default {
  computed: {
    previewItem() {
      return this.item
    },
  },
}
