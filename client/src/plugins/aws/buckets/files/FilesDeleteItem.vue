<template>
  <div align="center" justify="end" no-gutters>
    <div v-if="confirm">
      <v-btn v-bind="{ loading }" depressed color="error" @click="onConfirm"
        >Delete</v-btn
      >
      <v-btn
        :disabled="loading"
        depressed
        class="ml-1"
        @click="setConfirm(false)"
        >Cancel</v-btn
      >
    </div>

    <m-tooltip v-if="!confirm" value="Delete">
      <v-btn icon @click="setConfirm(true)">
        <v-icon>mdi-trash-can-outline</v-icon>
      </v-btn>
    </m-tooltip>
  </div>
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
      deleteObject: 'awsBuckets/deleteObject',
    }),
    setConfirm(value) {
      this.confirm = value
      this.$emit('input', value)
    },
    async onConfirm() {
      this.loading = true
      const ok = await this.deleteObject(this.itemKey)

      if (ok) {
        this.$app.success('Deleted!')

        this.setConfirm(false)
      } else {
        this.$app.error('Unable to delete file')
      }
      this.loading = false
    },
  },
}
</script>
