<template>
  <div>
    <m-tooltip value="Delete Page" :disabled="confirm">
      <v-btn
        :large="!confirm"
        :icon="!confirm"
        :color="confirm ? 'error' : ''"
        :loading="loading"
        v-on="{ click }"
      >
        <span v-if="confirm">Delete {{ isChild ? 'Page' : 'Offer' }}?</span>
        <v-icon v-else>mdi-trash-can-outline</v-icon>
      </v-btn>
    </m-tooltip>
    <v-btn
      v-if="confirm"
      :disabled="loading"
      depressed
      class="ml-2"
      @click="confirm = false"
      >Cancel</v-btn
    >
  </div>
</template>

<script>
import { getBucketFileName } from '../../helpers'
import { mapActions } from 'vuex'
export default {
  props: {
    isChild: Boolean,
    pageId: {
      type: String,
      required: true,
    },
    slug: {
      type: String,
      required: true,
    },
    // getBucket: {
    //   type: Function,
    //   default: null,
    // },
  },

  data() {
    return {
      confirm: false,
      loading: false,
    }
  },

  methods: {
    ...mapActions({
      getBucket: 'adam/getBucket',
    }),
    async click() {
      if (!this.confirm) {
        return (this.confirm = true)
      }

      this.loading = true

      const bucketFile = getBucketFileName(this.slug)

      const bucket = await this.getBucket()

      // delete page, delete bucket
      if (this.isChild) {
        await bucket.deleteObject(bucketFile)
      }

      // offer delete
      else {
        const fileNames = await this.$app.get(
          `/pages/${this.pageId}/offer-file-names`
        )
        await bucket.deleteObjects(fileNames.data)
      }

      // delete pages after offer pages removed from bucket

      await this.$app.post(`/pages/${this.pageId}/delete`)

      this.loading = false
      this.confirm = false

      this.$emit('deleted')
    },
  },
}
</script>
