<template>
  <v-card-title class="mb-4">
    <v-badge :value="!!totalItems" :content="totalItems" class="mb-n5">
      <div class="title">{{ collection.title }}</div>
    </v-badge>
    <v-spacer />
    <v-text-field
      v-model="query.q"
      append-icon="mdi-magnify"
      label="Search"
      single-line
      hide-details
      clearable
      v-on:keyup.enter="search"
      @click:clear="clearSearch"
      @blur="onSearchBlur"
    >
      <template v-slot:append-outer>
        <v-btn icon class="mt-n1 mb-n3" :loading="refreshing" @click="refresh">
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </template>
    </v-text-field>
  </v-card-title>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
export default {
  computed: {
    ...mapState({
      collection: 'collection',
    }),
    ...mapGetters({
      totalItems: 'collection/totalItems',
      query: 'collection/query',
      refreshing: 'collection/refreshing',
    }),
  },

  methods: {
    ...mapActions({
      onSearchBlur: 'collection/onSearchBlur',
      search: 'collection/search',
      clearSearch: 'collection/clearSearch',
      refresh: 'collection/refresh',
    }),
  },
}
</script>
