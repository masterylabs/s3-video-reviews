<template>
  <div>
    <v-progress-linear
      v-if="!isRemoteSearch && isLoading"
      indeterminate
      color="primary"
      class="mt-5 mb-4"
    />
    <v-divider v-else-if="divider" class="my-5" />

    <slot name="top" />

    <v-toolbar
      v-if="!isRemoteSearch"
      dense
      flat
      class="mb-5"
      color="transparent"
    >
      <v-badge :value="!!total" :content="total">
        <v-toolbar-title>{{ title }}</v-toolbar-title>
      </v-badge>
      <form @submit.prevent="onSearch">
        <v-text-field
          v-model="pages.form.q"
          hide-details
          class="ml-8"
          rounded
          prepend-inner-icon="mdi-magnify"
          label="Search..."
          clearable
          @click:clear="onSearchClear"
        />
      </form>
      <v-spacer />

      <slot name="toolbar-actions" />

      <div class="mr-n4"></div>
    </v-toolbar>

    <slot v-if="pages.ready && !pages.items.data.length" name="no-results" />

    <v-row class="mb-5">
      <v-col
        v-for="pageItem in items"
        :key="pageItem.id"
        cols="12"
        sm="6"
        md="4"
      >
        <adam-page-card
          :item="pageItem"
          v-bind="{
            baseUrl,
            baseEndpoint: endpoint,
            bucketName,
            bucketRegion,
            bucketDomain,
          }"
          v-on="{ select, deleted }"
        >
          <template v-slot:actions-append="{ item }">
            <slot name="actions-append" :item="item" />
          </template>
        </adam-page-card>
      </v-col>
    </v-row>

    <v-row v-if="totalPages > 1" no-gutters align="center">
      <v-col>
        <v-pagination
          v-model="pages.form.page"
          :length="totalPages"
          @input="getItems"
        />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { filterItems } from '../helpers/filter'

export default {
  props: {
    divider: Boolean,
    slug: {
      type: String,
      default: '',
    },
    title: {
      type: String,
      default: 'Offer Pages',
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
    endpoint: {
      type: String,
      default: 'pages',
    },
  },

  computed: {
    ...mapGetters({
      // watch for page refresh from outside
      refreshPages: 'adam/refreshPages',
      remoteSearch: 'search',
      // bucketName: 'adam/bucketName',
      // bucketRegion: 'adam/bucketRegion',
      pages: 'adam/pages',
      // pagesWithChanges: 'adam/pagesWithChanges',

      // changes: 'adam/changes',
    }),
    isRemoteSearch() {
      return this.$route.name === 'home'
    },
    isLoading() {
      for (const k in this.pages.loading) {
        if (this.pages.loading[k]) return true
      }

      return false
    },

    baseUrl() {
      let url = this.$store.getters.config.baseurl
      if (this.$store.getters.settings.prefix) {
        url += `/${this.$store.getters.settings.prefix}`
      }

      if (this.slug) {
        url += this.slug
      }

      return url
    },

    total() {
      return this.pages.items.pagin.total || 0
    },

    totalPages() {
      return this.pages.items.pagin.pages
    },

    items() {
      if (!this.pages.items.data || !this.pages.items.data.length) {
        if (this.isRemoteSearch) {
          this.$store.commit('SEARCH', { total: 0 })
        }
        return []
      }

      // return this.items.data
      const q = this.isRemoteSearch ? this.remoteSearch.q : this.pages.form.q

      const items = filterItems(this.pages.items.data, q, [
        'id',
        'page_type',
        'name',
        'description',
      ])

      if (this.isRemoteSearch) {
        this.$store.commit('SEARCH', { total: items.length })
      }

      return items
    },
  },

  methods: {
    onSearchClear() {
      this.pages.form.page = 1
      this.pages.form.q = ''
      this.getItems()
    },
    onSearch() {
      this.pages.form.page = 1
      this.getItems()
    },

    refresh() {
      this.pages.form.page = 1
      this.getItems()
    },

    async getItems() {
      if (this.isRemoteSearch) {
        this.$store.dispatch('loading', true)
      }
      this.pages.loading.items = true
      this.pages.items = await this.$app.get(this.endpoint, this.form)

      this.pages.loading.items = false
      if (this.isRemoteSearch) {
        this.$store.dispatch('loading', false)
      }
    },

    select(itemId) {
      this.$emit('select', itemId)
    },

    deleted() {
      this.refresh()
    },
  },

  beforeDestroy() {
    this.$store.commit('adam/CLEAR_PAGES')
  },

  async created() {
    await this.getItems()
    this.pages.ready = true
  },

  async mounted() {
    if (this.isRemoteSearch) {
      const doSearch = async () => {
        this.pages.form.page = 1
        await this.getItems()
      }

      this.$store.subscribe(({ type }, { search }) => {
        if (type === 'SEARCH') {
          this.pages.form.q = search.q
        }

        if (type === 'SEARCH_SEARCH') {
          doSearch()
        }
      })
    }
  },

  watch: {
    refreshPages() {
      this.refresh()
    },
    // total(total) {
    //   //
    //   if (this.isRemoteSearch) {
    //     // this.$store.commit('SEARCH', { total })
    //   }
    // },
  },
}
</script>
