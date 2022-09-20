<template>
  <div>
    <v-tooltip v-if="!refreshing" bottom>
      <template v-slot:activator="{ attrs, on }">
        <span v-bind="attrs" v-on="on">
          <v-file-input
            ref="selector"
            hide-input
            multiple
            style="display: none"
            @change="change"
          />
        </span>
      </template>
      <span>Add File</span>
    </v-tooltip>
    <v-btn
      depressed
      color="primary"
      class="font-weight-medium text-none"
      v-on="{ click }"
      >Add File</v-btn
    >
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      refreshing: false,
    }
  },

  methods: {
    ...mapActions({
      queUploads: 'awsBuckets/queUploads',
    }),

    click() {
      this.$refs.selector.$refs.input.click()
    },

    change(files) {
      this.queUploads(files)
      // enable same file to be selected again
      this.refreshing = true
      setTimeout(() => {
        this.refreshing = false
      })
    },
  },
}
</script>
