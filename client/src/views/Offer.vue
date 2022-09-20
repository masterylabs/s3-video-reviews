<template>
  <div>
    <m-page-loading v-if="!ready" />

    <v-breadcrumbs :items="crumbs" class="text-lowercase" />

    <v-container>
      <adam-page-builder
        v-bind="{ endpoint }"
        v-on="{ deleted, select, invalid }"
      />
    </v-container>
  </div>
</template>

<script>
import hasChangesMixin from '@/mixins/has-changes'

export default {
  mixins: [hasChangesMixin],
  computed: {
    ready() {
      return this.$store.getters['adam/ready']
    },
    name() {
      return this.$store.getters['adam/pageName']
    },
    hasChanges() {
      return this.$store.getters['adam/hasChanges']
    },
    endpoint() {
      return `/pages/${this.$route.params.id}`
    },
    crumbs() {
      return [
        {
          text: 'Home',
          exact: true,
          disabled: false,
          to: {
            name: 'home',
          },
        },
        {
          disabled: true,
          text: this.name,
        },
      ]
    },
  },

  methods: {
    deleted() {
      return this.$router.replace({
        name: 'home',
      })
    },
    select(id) {
      this.$router.push({
        name: 'offer-page',
        params: {
          parent_id: this.$route.params.id,
          id,
        },
      })
    },
    invalid() {
      this.$router.replace({ name: 'home' })
    },
  },
}
</script>
