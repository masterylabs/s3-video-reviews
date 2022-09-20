<template>
  <div>
    <m-delete-btn depressed :loading="deleting" @confirm="deleteSelected">
      Delete Selected
    </m-delete-btn>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  props: {
    value: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      deleting: false,
    }
  },

  methods: {
    ...mapActions({
      deleteObjects: 'awsBuckets/deleteObjects',
    }),
    async deleteSelected() {
      this.deleting = true
      //
      const keys = this.value.map((a) => a.Key)
      await this.deleteObjects(keys)
      this.deleting = false
      this.$emit('deleted', keys)
    },
  },
}
</script>
