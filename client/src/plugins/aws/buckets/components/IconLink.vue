<template>
  <m-tooltip value="Go To AWS" :disabled="!icon">
    <v-btn
      v-bind="{ icon, depressed }"
      :class="btnClass"
      :href="url"
      target="_blank"
    >
      <slot>
        <v-icon large>mdi-aws</v-icon>
      </slot>
    </v-btn>
  </m-tooltip>
</template>

<script>
export default {
  props: {
    depressed: Boolean,
    icon: {
      type: Boolean,
      default: true,
    },
    btnClass: {
      type: String,
      default: '',
    },
    bucketName: {
      type: String,
      default: '',
    },
    bucketRegion: {
      type: String,
      default: '',
    },
  },

  computed: {
    url() {
      let url = 'https://s3.console.aws.amazon.com/s3/buckets'

      if (this.bucketName && this.bucketRegion) {
        url += `/${this.bucketName}?region=${this.bucketRegion}&tab=objects`
      }
      return url
    },
  },
}
</script>
