<template>
  <v-toolbar flat>
    <v-toolbar-title>Branding</v-toolbar-title>
    <v-spacer />

    <v-switch
      v-model="settings.is_active"
      label="Active"
      hide-details
      class="mr-5 mb-n1"
      @change="onActive"
    />
    <v-btn
      v-bind="{ loading, disabled: !hasChanges }"
      @click="submit"
      color="primary"
      >Save Changes
    </v-btn>
  </v-toolbar>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import colorMixin from '../mixins/color'
import brandMixin from '../mixins/brand'

export default {
  mixins: [colorMixin, brandMixin],

  data() {
    return {
      loading: false,
    }
  },

  computed: {
    ...mapGetters({
      hasChanges: 'brand/hasChanges',
      settings: 'brand/settings',
      config: 'config',
    }),
  },

  methods: {
    ...mapActions({
      saveSettings: 'brand/saveSettings',
    }),

    onActive() {
      if (this.settings.is_active) {
        this.setColors()
        this.setBrand()
      } else {
        this.unsetColors()
        this.unsetBrand()
      }
    },

    async submit() {
      this.loading = true
      await this.saveSettings()

      this.loading = false

      this.maybeRedirect()
    },

    maybeRedirect() {
      if (window.location.host.indexOf('localhost:808') === 0) {
        // return
      }
      const slug = this.settings.is_active
        ? this.settings.slug
        : 's3-video-reviews'

      console.log('slug', slug)

      let part = window.top.location.href.split('?page=')
      const currentSlug = part[1].split('#')[0]

      console.log({ currentSlug }, part)

      if (currentSlug !== slug) {
        this.$app.message('Redirecting to a new url...')
        const url = part[0] + `?page=${slug}#/brand/admin`
        // return
        window.top.location.href = url
        console.log('redirect to ', url)
      }
    },
  },
}
</script>
