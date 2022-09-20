<template>
  <adam-card
    :actions="actions"
    :icon="icons[item.page_type]"
    :src="item.admin_image"
    @select="onSelect"
  >
    {{ item.name || item.id }}
    <template v-slot:actions-append>
      <slot name="actions-append" :item="item" />
    </template>
    <template v-slot:more>
      <div class="text-center font-weight-bold mb-5">
        <div class="body-1">Page URL</div>

        <a :href="url" target="_blank" v-text="url" />
      </div>

      <div v-if="item.title" class="mb-3">
        <div class="font-italic grey--text">Title</div>
        <div class="body-1">
          {{ item.title }}
        </div>
      </div>

      <div class="mb-3">
        <div class="font-italic grey--text">Product</div>
        <p>
          {{ item.prod_name || '-' }}
        </p>
      </div>

      <div class="mb-3">
        <div class="font-italic grey--text">Description</div>
        <p>
          {{ item.description || '-' }}
        </p>
      </div>

      <div class="mb-3">
        <div class="font-italic grey--text">Bucket Name</div>
        <p>
          <a :href="bucketLink" target="_blank">{{
            bucketName || item.bucket_name
          }}</a>
        </p>
      </div>

      <v-row
        v-if="isChild"
        align="center"
        justify="end"
        no-gutters
        class="mt-4 mb-n6"
      >
        <adam-delete-page-btn
          v-bind="{ isChild, pageId: item.id, slug: item.slug }"
          @deleted="onDeleted"
        />
      </v-row>
    </template>
  </adam-card>
</template>

<script>
import icons from '../templates/page-icons'

export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
    bucketName: {
      type: String,
      default: '',
    },
    bucketRegion: {
      type: String,
      default: '',
    },
    bucketDomain: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      loading: '',
      icons,
      actions: [
        {
          text: 'Open',
          icon: 'mdi-open-in-new',
          click: this.openOffer,
        },
        {
          text: 'Copy Link',
          icon: 'mdi-content-copy',
          click: this.copyLink,
        },
      ],
    }
  },

  computed: {
    isChild() {
      return this.item.page_type !== 'offer'
    },
    url() {
      let url
      if (this.item.bucket_domain || this.bucketDomain) {
        url = this.item.bucket_domain || this.bucketDomain
        if (url.indexOf('://') < 0) {
          url = `https://${url}`
        }
      } else {
        const name = this.bucketName || this.item.bucket_name
        const region = this.bucketRegion || this.item.bucket_region

        url = `http://${name}.s3-website.${region}.amazonaws.com`
      }

      if (this.item.page_type !== 'offer') {
        url += `/${this.item.slug}`
      }

      return url
    },

    bucketLink() {
      let url = 'https://s3.console.aws.amazon.com/s3/buckets'

      const name = this.bucketName || this.item.bucket_name
      const region = this.bucketRegion || this.item.bucket_region

      if (name && region) {
        url += `/${name}?region=${region}&tab=objects`
      }
      return url
    },
  },

  methods: {
    onDeleted() {
      this.$emit('deleted')
    },
    openOffer() {
      window.open(this.url)
    },
    copyLink() {
      this.$copyText(this.url).then(() => {
        this.$app.success(this.m.lang.SUCCESS_COPIED_TO_CLIPBOARD)
      })
    },
    onSelect() {
      this.$emit('select', this.item.id)
    },
  },

  created() {},
}
</script>
