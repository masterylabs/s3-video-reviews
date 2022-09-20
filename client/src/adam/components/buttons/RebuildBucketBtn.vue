<template>
  <v-btn depressed :loading="rebuildingBucket" @click="rebuildBucket"
    >Rebuild Bucket</v-btn
  >
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      rebuildingBucket: false,
    }
  },

  methods: {
    ...mapActions({
      setupBucket: 'adam/setupBucket',
    }),
    async rebuildBucket() {
      this.rebuildingBucket = true
      const success = await this.setupBucket()
      this.rebuildingBucket = false

      if (success) {
        this.$app.success('Rebuild Complete!')
      } else {
        this.$app.error('Unable to complete rebuild')
      }
    },
  },
}
</script>
