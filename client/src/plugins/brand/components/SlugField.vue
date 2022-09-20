<template>
  <v-text-field v-model="settings.slug" :label="label" v-on="{ blur }" />
</template>

<script>
  import { mapGetters } from 'vuex'
  const slugify = require('slugify')
  export default {
    props: {
      label: {
        type: String,
        default: '',
      },
    },

    computed: {
      ...mapGetters({
        settings: 'brand/settings',
      }),
    },

    methods: {
      blur() {
        let slug = this.settings.slug || this.settings.name

        slug = slugify(slug, {
          lower: true,
          strict: true,
        })

        if (slug.length < 10) {
          const n = 10 - slug.length
          slug += '-'(Math.random() + 1)
            .toString(36)
            .substring(n)
        }

        this.settings.slug = slug
      },
    },
  }
</script>
