<template>
  <div>
    <div class="title">Set Bucket CORS</div>
    <aws-buckets-cors-snippet
      :bucket-name="form.bucket_name"
      :region="form.bucket_region"
      toggle-add-bucket-dialog
      emit-copy
      @copy="onCopyCors"
    />

    <v-row justify="space-between" no-gutters class="mt-8">
      <v-btn color="primary" v-bind="{ loading, disabled }" @click="submit"
        >Continue</v-btn
      >
      <v-btn depressed @click="stepper.value--">Back</v-btn>
    </v-row>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import copyToClipboard from '@/mixins/copy-to-clipboard'
//
export default {
  mixins: [copyToClipboard],
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    ...mapGetters({
      form: 'addOffer/form',
      stepper: 'addOffer/stepper',
    }),
    disabled() {
      return !this.form.bucket_name || !this.form.bucket_region
    },
  },

  methods: {
    ...mapActions({
      getBucket: 'addOffer/getBucket',
    }),
    onCopyCors(snippet) {
      this.stepper.dialog = false
      setTimeout(() => {
        this.$copyText(snippet)
          .then(() => {
            this.$app.success('Copied to clipboard!')
            this.stepper.dialog = true
          })
          .catch(() => {
            this.stepper.dialog = true
          })
      }, 1)
    },
    async submit() {
      await this.checkCors()
      if (!this.valid) {
        this.$app.error(
          'Unable to connect. Make sure bucket name, region and cors are correct'
        )
      }
    },

    async checkCors() {
      this.loading = true

      const bucket = await this.getBucket()

      this.valid = await bucket.checkCors()
      this.loading = false

      if (this.valid) {
        this.stepper.value++
      }
    },
  },

  async mounted() {
    await this.checkCors()
  },
}
</script>
