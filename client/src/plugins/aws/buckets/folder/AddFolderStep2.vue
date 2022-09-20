<template>
  <edit-folder
    v-if="item"
    v-bind="{ item }"
    no-delete
    @close="onClose"
    is-add
  />
</template>

<script>
import mixin from './mixins'

export default {
  mixins: [mixin],
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    item() {
      return this.folders.find((a) => a.Key === this.data.Key)
    },
  },

  methods: {
    onClose() {
      this.data.dialog = false
      this.data.Key = ''

      setTimeout(() => {
        this.data.step = 1
        this.clearForm()
      }, 1500)
    },
  },
}
</script>
