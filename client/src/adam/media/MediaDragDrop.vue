<template>
  <div ref="container" style="position: absolute; width: 100%; height: 100%">
    <slot />

    <aws-buckets-drag-overlay v-if="isDragOver" />
  </div>
</template>

<script>
// bucket
import { mapActions } from 'vuex'
import { getDataTransferItems } from '@/plugins/aws/buckets/helpers'
export default {
  data() {
    return {
      isDragOver: false,
      leaveWait: null,
    }
  },

  methods: {
    ...mapActions({
      processMediaItems: 'adam/processMediaItems',
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

      const items = await getDataTransferItems(e.dataTransfer.items)

      await this.processMediaItems(items)
    },

    // async processItems(items) {
    //   const validItems = []

    //   for (const k in items) {
    //     // validate

    //     if (typeof items[k] !== 'object') {
    //       continue
    //     }

    //     const item = items[k]

    //     const isHidden = item.name.charAt(0) === '.'
    //     // const fullFileName = item._dirPath + item.name

    //     // skip hidden files

    //     if (isHidden) {
    //       continue
    //     }

    //     // que upload
    //     this.mediaUpload(item)
    //     // validItems.push(item)
    //     //   dispatch('queUpload', item)

    //     if (item._isDir && item.children && item.children.length) {
    //       // dispatch('_processDataTransferItems', item.children)
    //     }
    //   }
    // },
  },
  //
  mounted() {
    const container = this.$refs.container
    const target = this.$refs.container

    container.addEventListener('dragover', this.ddOver)
    target.addEventListener('dragenter', this.ddEnter)
    target.addEventListener('mouseleave', this.ddLeave)
    target.addEventListener('drop', this.ddDrop)
  },

  beforeDestroy() {
    const container = this.$refs.container
    const target = this.$refs.container

    container.removeEventListener('dragover', this.ddOver)
    target.removeEventListener('dragenter', this.ddEnter)
    target.removeEventListener('mouseleave', this.ddLeave)
    target.removeEventListener('drop', this.ddDrop)
  },
}
</script>
