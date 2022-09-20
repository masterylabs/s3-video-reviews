<template>
  <v-toolbar dense flat rounded color="transparent">
    <v-toolbar-title>{{ title }}</v-toolbar-title>

    <v-spacer />
    <!-- <adam-offer-url /> -->
    <!-- <adam-copy-btn :value="isHome ? $app.config.homeurl : pageUrl" /> -->

    <!-- <adam-home-page-dialog v-if="!isChild" :page-id="pageId" /> -->

    <div class="mx-1" />
    <adam-preview-dialog :page-id="pageId" />
    <adam-save-changes-btn class="ml-2" />
    <!-- <m-toggle-chevron v-model="more" /> -->
  </v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex'
import pageUrlMixin from '../mixins/page-url'
import copyToClipboard from '@/mixins/copy-to-clipboard'

export default {
  mixins: [pageUrlMixin, copyToClipboard],

  data() {
    return {
      isReady: false,
      more: false,
      timed: {
        video: '',
      },
    }
  },

  computed: {
    ...mapGetters({
      title: 'adam/pageName',
      isChild: 'adam/isChild',
      pageId: 'adam/pageId',
      url: 'adam/pageUrl',

      // test
      // page: 'adam/page',
      // theme: 'adam/theme',
    }),

    isHome() {
      return this.$store.getters.settings &&
        this.$store.getters.settings.homepage === this.pageId
        ? true
        : false
    },
  },

  methods: {
    copyUrl() {
      this.copyToClipboard(this.url)
    },
    toggleMore() {
      this.more = !this.more
    },
  },
}
</script>
