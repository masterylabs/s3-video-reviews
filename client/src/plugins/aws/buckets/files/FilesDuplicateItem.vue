<template>
  <m-tooltip value="Duplicate File">
    <v-btn v-bind="{ loading }" icon @click="submit">
      <v-icon>mdi-content-copy</v-icon>
    </v-btn>
  </m-tooltip>
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
      confirm: false,
      loading: false,
    }
  },

  methods: {
    ...mapActions({
      duplicateFile: 'awsBuckets/duplicateFile',
    }),

    async submit() {
      this.loading = true
      const ok = await this.duplicateFile(this.itemKey)

      if (ok) {
        this.$app.success('Duplicated!')
      } else {
        this.$app.error('Unable to duplicate file')
      }
      this.loading = false
    },
  },
}
</script>
