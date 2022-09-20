<template>
  <div>
    <p>
      Use the following snippet for both source and destination bucket CORS.
      <br />
      (Amazon S3 >
      <a :href="url" target="_blank">Buckets</a>
      >
      <a v-if="bucketName" :href="`${url}/${bucketName}`" target="_blank">{{
        bucketName
      }}</a>
      <span v-else>Your Bucket</span>
      >
      <a
        v-if="bucketName && region"
        :href="`https://s3.console.aws.amazon.com/s3/buckets/${bucketName}?region=${region}&tab=permissions`"
        target="_blank"
        >Permissions > CORS)</a
      >
      <span v-else> Permissions > CORS) </span>
    </p>
    <v-textarea :value="snippet" small outlined readonly />

    <v-btn depressed class="mt-n2" @click="copyCors">Copy To Clipboard</v-btn>
  </div>
</template>

<script>
import copyToClipboard from '@/mixins/copy-to-clipboard'
import { mapGetters } from 'vuex'
export default {
  props: {
    emitCopy: Boolean,
    width: {
      type: [String, Number],
      default: 500,
    },
    bucketName: {
      type: String,
      default: '',
    },
    region: {
      type: String,
      default: '',
    },
    toggleAddBucketDialog: Boolean,
  },

  mixins: [copyToClipboard],

  data() {
    return {
      url: 'https://s3.console.aws.amazon.com/s3/buckets',
      snippet: `[
    {
        "AllowedHeaders": [
            "*"
        ],
        "AllowedMethods": [
            "HEAD",
            "GET",
            "PUT",
            "POST",
            "DELETE"
        ],
        "AllowedOrigins": [
            "*"
        ],
        "ExposeHeaders": []
    }
]`,
    }
  },

  computed: {
    ...mapGetters({
      data: 'awsBuckets/addBucket',
    }),
  },

  methods: {
    copyCors() {
      if (this.emitCopy) {
        return this.$emit('copy', this.snippet)
      }
      if (!this.toggleAddBucketDialog) {
        return this.copyToClipboard(this.snippet)
      }

      // dialog support
      this.data.dialog = false
      setTimeout(() => {
        this.$copyText(this.snippet)
          .then(() => {
            this.$app.success('Copied to clipboard!')
            this.data.dialog = true
          })
          .catch(() => {
            this.data.dialog = true
          })
      }, 1)
    },
  },
}
</script>
