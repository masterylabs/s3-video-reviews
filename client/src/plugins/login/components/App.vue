<template>
  <v-app class="app-container">
    <slot v-if="ready && !showLogin" />
    <v-main v-else>
      <v-container fill-height>
        <v-row align="center" justify="center">
          <login-login-form v-if="showLogin" />
          <slot v-else name="app-loading">
            <v-progress-circular
              indeterminate
              color="primary"
              size="180"
            ></v-progress-circular>
          </slot>
        </v-row>
      </v-container>
    </v-main>
    <!-- <slot /> -->
    config: {{ config.use_login }}, {{ showLogin }}
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      ready: 'ready',
      validLicense: 'license/valid',
      loading: 'loading',
      access: 'access',
      settings: 'settings',
      config: 'config',
      user: 'user',
    }),
    showLogin() {
      return this.ready && this.config.use_login && !this.user.authenticated
    },
  },
}
</script>
