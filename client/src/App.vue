<template>
  <v-app class="app-container">
    <m-navbar v-if="ready && validLicense && connected" />

    <v-fade-transition>
      <m-bg-image v-if="bgPreview" v-bind="bgPreview" />
    </v-fade-transition>

    <m-bg-image-mobi-preview />

    <v-main class="grey lighten-5">
      <v-progress-linear
        v-if="loading"
        indeterminate
        absolute
        height="5"
        color="accent"
      ></v-progress-linear>

      <template v-if="ready">
        <unconnected-view v-if="!connected" />
        <license-activation-view v-else-if="ready && !validLicense" />
        <router-view v-else-if="ready" />
      </template>
    </v-main>

    <license-update-dialog />
    <message-message />
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import UnconnectedView from './views/UnconnectedView.vue'
import brandColorMixin from './plugins/brand/mixins/color'
export default {
  components: {
    UnconnectedView,
  },

  mixins: [brandColorMixin],

  name: 'App',

  data: () => ({
    ready: false,
    connected: false,
    // validLicense: true,
  }),

  computed: {
    ...mapGetters({
      validLicense: 'license/valid',
      loading: 'loading',
      access: 'access',
      settings: 'settings',
      user: 'user',
      bgImage: 'layout/bgImage',
      bgPreview: 'adam/bgPreview',
    }),
  },

  async created() {
    this.setColors(this.$app.config)

    await this.$app.start('admin')

    this.connected = this.$app.connected

    this.$store.dispatch('onReady')

    this.ready = true

    if (!this.settings) {
      return // not logged in
    }

    if (!this.settings.aws_access_key && this.$route.name !== 'settings') {
      this.$router.push({ name: 'settings' })
    }
  },
}
</script>

<style lang="scss">
.app-container {
  background-color: rgb(224, 224, 224);
}
.ml-pointer {
  cursor: pointer;
}
.no-select {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
}
// .v-data-table > .v-data-table__wrapper > table {
//   color: #e5e5e5;
// }
// s3 video offers
.input-disabled input {
  color: #929292 !important;
}
.v-text-field__slot textarea {
  padding-top: 4px !important;
}
.v-expansion-panel-content {
  padding-top: 16px;
}
.v-expansion-panel-header {
  font-size: 16px !important;
  color: #000;
}

.v-dialog__content {
  max-height: 860px !important;
}
</style>
