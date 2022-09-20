<template>
  <div class="text-left">
    <div v-if="isHome">
      <a
        :href="$app.config.homeurl"
        target="_blank"
        class="mr-2"
        v-text="$app.config.homeurl"
      />
    </div>
    <div>
      <a :href="pageUrl" target="_blank" class="mr-2" v-text="pageUrl" />
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import pageUrlMixin from '../mixins/page-url'

export default {
  mixins: [pageUrlMixin],

  data() {
    return {
      isReady: false,
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
}
</script>
