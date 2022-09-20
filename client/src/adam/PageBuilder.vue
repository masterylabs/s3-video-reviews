<template>
  <div>
    <adam-layout v-if="isReady && ready">
      <template v-slot:links>
        <v-row align="center" justify="center">
          <!-- <v-col> -->
          <adam-page-url
            v-if="customUrl"
            :value="customUrl"
            title="Custom Website URL"
            class="mx-3"
          />

          <adam-page-url :value="pageUrl" title="Website URL" class="mx-3" />
        </v-row>
      </template>
      <template v-slot:header>
        <adam-toolbar />
      </template>

      <template v-slot:main v-if="ready">
        <adam-panels />
      </template>

      <template v-slot:footer>
        <v-fade-transition>
          <div v-if="ready && !isChild">
            <adam-pages
              v-bind="{
                slug: `/${slug}`,
                endpoint: `${endpoint}/pages`,
                bucketName,
                bucketRegion,
                bucketDomain,
                divider: true,
              }"
              v-on="{ select }"
            >
              <template v-slot:top>
                <!-- <v-divider class="my-5" /> -->
                <v-row no-gutters justify="end" class="mx-n3">
                  <adam-add-child-pages-btn slot="toolbar-actions" />
                </v-row>
              </template>
            </adam-pages>
          </div>
        </v-fade-transition>
      </template>

      <v-row justify="end" no-gutters>
        <adam-delete-page-btn
          v-bind="{ slug, pageId, isChild, getBucket }"
          v-on="{ deleted }"
        />
      </v-row>
    </adam-layout>
    <adam-media-dialog v-if="isReady" />
    <!-- <m-code>
      {{ page }}
    </m-code> -->
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex'
import pageUrlMixin from './mixins/page-url'

export default {
  mixins: [pageUrlMixin],
  props: {
    endpoint: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isReady: false,
      timed: {
        video: '',
      },
    }
  },

  computed: {
    ...mapState({
      adam: 'adam',
    }),
    ...mapGetters({
      ready: 'adam/ready',
      name: 'adam/pageName',
      slug: 'adam/slug',
      // endpoint: 'adam/endpoint',
      isChild: 'adam/isChild',
      pageId: 'adam/pageId',
      pageUrl: 'adam/pageUrl',
      customUrl: 'adam/customUrl',

      // test
      page: 'adam/page',
      // theme: 'adam/theme',
      fileName: 'adam/fileName',
      previewData: 'adam/livePreviewData',
      slugChanged: 'adam/slugChanged',
      parentId: 'adam/parentId',

      bucketName: 'adam/bucketName',
      bucketRegion: 'adam/bucketRegion',
      bucketDomain: 'adam/bucketDomain',
      // test

      // pagesWithChanges: 'adam/pagesWithChanges',
    }),

    isHome() {
      return this.$store.getters.settings &&
        this.$store.getters.settings.homepage === this.pageId
        ? true
        : false
    },
  },

  methods: {
    ...mapActions({
      getBucket: 'adam/getBucket',
      saveOfferPages: 'adam/saveOfferPages',
    }),
    select(id) {
      this.$emit('select', id)
    },

    deleted() {
      this.$emit('deleted')
    },
  },

  beforeDestroy() {
    this.isReady = false
    this.$store.dispatch('adam/destroy')
  },

  async created() {
    await this.$store.dispatch('adam/load', this.endpoint)

    if (!this.ready) {
      return this.$emit('invalid')
    }

    this.isReady = true
  },
}
</script>
