<template>
  <v-row no-gutters>
    <v-switch
      v-model="settings.meta.is_teams"
      @change="onChange"
      label="Teams"
    ></v-switch>
    <m-tooltip
      value="Teams enables other users to have their own buckets and settings"
    >
      <v-icon small class="mt-3">mdi-help-circle</v-icon>
    </m-tooltip>
  </v-row>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      settings: 'settings',
      user: 'user',
      hasChanges: 'hasChanges',
    }),
  },

  methods: {
    onChange() {
      // if (!this.settings.meta.teams_admin) {
      this.settings.meta.teams_admin = this.user.username
      // }
    },
  },

  created() {
    if (!this.settings.meta) {
      this.settings.meta = {}
    }
  },
}
</script>
