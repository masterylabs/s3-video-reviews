import { isFirstEl } from '../helpers/dom'

export default {
  data() {
    return {
      itemEdged: {
        pa: 0,
      },
    }
  },
  mounted() {
    //
    // const isFirst = isFirstEl(this.$el)
    // const parentNode = this.$el.parentNode
    // const pa = this.theme.pa
    // if (pa) {
    //   this.itemEdged.pa = parseInt(pa)
    //   parentNode.classList.add(`mx-n${pa}`)
    //   if (isFirst) {
    //     parentNode.classList.add(`mt-n${pa}`)
    //   }
    // } else {
    //   this.itemEdged.pa = 0
    // }
    // // parentNode.classList.add(`mt-n4`)
    //
  },
}
