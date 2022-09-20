<template>
  <div>
    <aws-buckets-cors-snippet
      :bucket-name="form.name"
      :region="form.region"
      toggle-add-bucket-dialog
    />
    <v-divider class="my-5"></v-divider>
    <v-row no-gutters>
      <v-btn color="primary" depressed v-bind="{ loading }" @click="next"
        >Continue</v-btn
      >
      <v-spacer />
      <v-btn @click="data.step = 1">Back</v-btn>
    </v-row>
  </div>
</template>

<script>
import mixin from './mixins'
import Bucket from '../models/Bucket'

export default {
  mixins: [mixin],
  data() {
    return {
      loading: false,
      valid: false,
      bucket: null,
    }
  },

  methods: {
    async next() {
      await this.checkCors()
      if (!this.valid) {
        this.$app.error(
          'Unable to connect. Make sure bucket name, region and cors are correct'
        )
      }
    },

    async checkCors() {
      this.loading = true
      if (!this.bucket) {
        this.bucket = new Bucket(this.form.name, this.bucketAuth)
      }
      this.valid = await this.bucket.checkCors()
      this.loading = false

      if (this.valid) {
        this.data.step = 3
      }
    },
  },

  async mounted() {
    this.$watch('data.form.name', () => {
      this.bucket = null
    })

    await this.checkCors()
  },
}
</script>
