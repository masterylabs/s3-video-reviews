<template>
  <div>
    <v-row
      class="text-center pa-2 mb-1"
      align="center"
      justify="center"
      no-gutters
    >
      <m-tooltip :value="title" :disabled="!title">
        <a
          class="primary--text text-decoration-underline mr-2"
          :href="value"
          target="_blank"
          >{{ value | url }}</a
        >
      </m-tooltip>
      <m-tooltip value="Open Link">
        <v-icon size="18" @click="open">mdi-open-in-new</v-icon>
      </m-tooltip>

      <div class="mx-1"></div>

      <m-tooltip value="Copy Link">
        <v-icon size="18" @click="copy">mdi-content-copy</v-icon>
      </m-tooltip>
    </v-row>
  </div>
</template>
<script>
import copyToClipboard from '../../mixins/copy-to-clipboard'
export default {
  mixins: [copyToClipboard],
  props: {
    value: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: '',
    },
  },

  methods: {
    open() {
      window.open(this.value)
    },
    copy() {
      this.copyToClipboard(this.value)
    },
  },

  filters: {
    url(value) {
      if (value.indexOf('://') > -1) {
        return value.split('://').pop()
      }
      return value
    },
  },
}
</script>
