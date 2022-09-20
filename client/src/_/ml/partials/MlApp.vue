<template>
  <v-app>
    <v-main v-if="(auth && !authenticated) || !appReady">
      <!-- <dev-raw :value="{ auth, authenticated, appReady }" /> -->

      <connection-error-view
        v-if="connectionError != false"
        :value="connectionError"
      />
      <loading-view v-else-if="!appReady" />
      <!-- if login show login  -->

      <activate-view v-else-if="activate" />
      <login-view v-else />
    </v-main>

    <!-- Custom Views  -->
    <template v-else-if="view">
      <component :is="`${view}-view`" />
    </template>
    <slot v-else />
    <ml-message />
  </v-app>
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    props: {
      auth: Boolean,
      activate: Boolean,
    },
    computed: {
      ...mapGetters({
        view: 'ml/view',
        connectionError: 'ml/connectionError',
      }),
    },
  }
</script>
