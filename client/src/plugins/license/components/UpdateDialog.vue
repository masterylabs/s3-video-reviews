<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500" persistent>
      <v-card class="py-3" elevation="12">
        <v-card-title class="text-h5">{{ _('UPDATE_LICENSE') }} </v-card-title>

        <v-card-text>
          <license-form @submitted="submitted">
            <template v-slot:append>
              <v-btn text color="primary" @click="dialog = false">{{
                _('CANCEL')
              }}</v-btn>
            </template>
          </license-form>
        </v-card-text>

        <v-btn absolute right top icon @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  computed: {
    dialog: {
      get() {
        return this.$store.state.license.updateDialog
      },
      set(updateDialog) {
        this.$store.commit('license/SET', { updateDialog })
      },
    },
  },

  methods: {
    submitted(success) {
      if (success) {
        this.dialog = false
      }
    },
  },
}
</script>
