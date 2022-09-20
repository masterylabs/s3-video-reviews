<template>
  <div>
    <m-page-loading v-if="!ready" />
    <v-breadcrumbs :items="crumbs" class="text-lowercase" />

    <v-container>
      <adam-page-builder v-bind="{ endpoint }" v-on="{ deleted, invalid }" />
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
    parentName() {
      return this.$store.getters['adam/parentName']
    },
    hasChanges() {
      return this.$store.getters['adam/hasChanges']
    },

    endpoint() {
      return `/pages/${this.$route.params.parent_id}/pages/${this.$route.params.id}`
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
        // {
        //   disabled: false,
        //   exact: true,
        //   text: 'Offers',
        //   to: {
        //     name: 'home',
        //   },
        // },
        {
          disabled: false,
          exact: true,
          text: this.parentName,
          to: {
            name: 'offer',
            params: {
              id: this.$route.params.parent_id,
            },
          },
        },
        // {
        //   disabled: true,
        //   text: 'pages',
        // },
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
        name: 'offer',
        params: { id: this.$route.params.parent_id },
      })
    },
    invalid() {
      this.deleted()
    },
  },
}
</script>
