// bucket
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      isDragOver: false,
      leaveWait: null,
    }
  },

  methods: {
    ...mapActions({
      onDropFiles: 'awsBuckets/onDropFiles',
      onDataTransfer: 'awsBuckets/onDataTransfer',
    }),
    //
    ddOver(e) {
      e.preventDefault()
    },
    ddEnter() {
      this.isDragOver = true
    },
    ddLeave() {
      this.isDragOver = false
    },
    async ddDrop(e) {
      e.preventDefault()

      this.isDragOver = false

      return this.onDataTransfer(e.dataTransfer)
    },
  },
  //
  mounted() {
    const container = document.querySelector('.app-container')
    const target = document.querySelector('main')

    container.addEventListener('dragover', this.ddOver)
    target.addEventListener('dragenter', this.ddEnter)
    target.addEventListener('mouseleave', this.ddLeave)
    target.addEventListener('drop', this.ddDrop)
  },

  beforeDestroy() {
    const container = document.querySelector('.app-container')
    const target = document.querySelector('main')

    container.removeEventListener('dragover', this.ddOver)
    target.removeEventListener('dragenter', this.ddEnter)
    target.removeEventListener('mouseleave', this.ddLeave)
    target.removeEventListener('drop', this.ddDrop)
  },
}
