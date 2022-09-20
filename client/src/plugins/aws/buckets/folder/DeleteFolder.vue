<template>
  <m-delete-btn
    depressed
    icon
    justify="end"
    v-bind="{ loading }"
    @confirm="deleteItem"
  >
    Delete Folder
  </m-delete-btn>
</template>
<script>
import { mapActions } from 'vuex'
export default {
  props: {
    itemKey: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      loading: false,
    }
  },

  methods: {
    ...mapActions({
      deleteFolder: 'awsBuckets/deleteFolder',
    }),

    async deleteItem() {
      this.loading = true
      await this.deleteFolder(this.itemKey)
      this.loading = false
    },
  },
}
</script>
