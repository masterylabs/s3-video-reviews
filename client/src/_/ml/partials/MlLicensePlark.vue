<template>
  <v-card class="text-center px-6 py-4" tile flat rounded="lg">
    <div class="text-uppercase grey--text caption mb-3">license</div>
    <div class="text-h5 grey lighten-3 rounded py-1 mb-4">{{ name }}</div>

    <div class="px-4 mb-4">
      <v-chip
        label
        v-for="addon in addons"
        :key="addon.app_id"
        class="mx-2 mb-3"
        color="toggle-on white--text text-uppercase"
      >
        {{ addon.name | addonName }}
      </v-chip>
    </div>
    <div v-if="lic.contact" class="grey--text mb-4 body-1">
      {{ lic.contact.first_name }} {{ lic.contact.last_name }}
    </div>

    <!-- TRIAL  -->
    <div v-if="lic.is_trial" class="title text-uppercase py-4">
      <div class="caption text-uppercase">Trial</div>
      <div
        class="mb-4"
        :class="`${lic.expires_in < 86400 ? 'error' : 'primary'}--text`"
      >
        {{ lic.expires_in | timeRemaining }}
      </div>
      <ml-upgrade-btn v-if="lic.can_upgrade" />
    </div>
  </v-card>
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    computed: {
      ...mapGetters({
        lic: 'ml/license',
        addons: 'ml/addons',
      }),
      name() {
        return this.lic.name
          ? this.lic.name
          : this.lic.product && this.lic.product.name
          ? this.lic.product.name
          : ''
      },
    },

    filters: {
      timeRemaining(t) {
        if (t > 86400) return `${Math.floor(t / 86400)} Days`

        if (t > 3600) return `${Math.floor(t / 3600)} Hours`

        if (t > 60) return `${Math.floor(t / 60)} Minutes`

        if (t > 0) return `${Math.floor(t / 60)} Seconds`

        return 'Expired'
      },

      addonName(str) {
        if (str.indexOf(': ') > -1) {
          const [, name] = str.split(':')
          return name
        }
        return str
      },
    },
  }
</script>
