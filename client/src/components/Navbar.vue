<template>
  <v-app-bar app color="secondary" dark dense>
    <span class="ml-pointer" @click="onTitleClick"
      ><m-logo color="primary"
    /></span>
    <v-toolbar-title
      class="font-weight-bold ml-pointer mr-4"
      @click="onTitleClick"
      >{{ app.name }}
    </v-toolbar-title>

    <v-text-field
      v-if="showSearch"
      hide-details
      rounded
      filled
      dense
      label="Search..."
      :loading="search.loading"
      class="mr-3"
      append-icon="mdi-magnify"
      v-on:keyup.enter="onSearch"
      @input="onSearchInput"
      @click:append="onSearch"
    />

    <!-- <div> -->
    <m-tooltip value="Number of offers">
      <ICountUp
        :endVal="search.total"
        v-if="search.total"
        class="accent--text title no-select"
      />
    </m-tooltip>
    <div class="mr-3"></div>
    <!-- </div> -->

    <div
      v-if="app.label"
      class="accent secondary--text ml-3 px-2 rounded text-uppercase mr-2"
      style="font-size: 13px; font-weight: 500; padding-top: 1px"
    >
      {{ app.label }}
    </div>
    <v-spacer />

    <m-add-offer />

    <v-toolbar-items class="mr-6 ml-8">
      <v-btn v-for="(item, i) in items" :key="i" v-bind="item.attrs" text>
        <v-icon v-text="item.icon" class="mr-1" />
        {{ _(item.text) }}
      </v-btn>
    </v-toolbar-items>

    <aws-buckets-icon-link
      v-bind="{ bucketName, bucketRegion }"
      btn-class="mr-6"
    />

    <license-navbar-menu v-if="!access.hide_license" />
  </v-app-bar>
</template>

<script>
import { mapGetters } from 'vuex'
import ICountUp from 'vue-countup-v2'
export default {
  components: {
    ICountUp,
  },
  data() {
    return {
      items: [],
      // lastSearch: ''
    }
  },

  computed: {
    ...mapGetters({
      bucketName: 'adam/bucketName',
      bucketRegion: 'adam/bucketRegion',
      search: 'search',
    }),
    loading() {
      return this.$store.getters.loading
    },
    app() {
      return this.$store.getters.app
    },
    access() {
      return this.$store.getters.access
    },
    showSearch() {
      return this.$route.name === 'home'
    },
  },

  methods: {
    toHome() {
      if (this.$route.name !== 'home') {
        this.$router.push({ name: 'home' })
      }
    },
    onSearch() {
      // this.lastSearch = this.search
      this.$store.commit('SEARCH_SEARCH')
      // this.$store.commit('SEARCH', { search: true })
    },

    onSearchInput(q) {
      this.$store.commit('SEARCH', { q })
      if (this.search.lastSearch && !q) {
        console.log('clear search')
        this.onSearch()
      }
    },

    onTitleClick() {
      this.toHome()
    },
  },

  created() {
    this.items = this.$app.getMenuItems()
  },
}
</script>
