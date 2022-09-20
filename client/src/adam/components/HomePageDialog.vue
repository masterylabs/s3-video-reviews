<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500" persistent>
      <template v-slot:activator="{ on, attrs }">
        <v-tooltip bottom>
          <template v-slot:activator="tooltip">
            <span v-bind="tooltip.attrs" v-on="tooltip.on">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
                :color="active ? 'success' : ''"
                large
                class="my-n2"
              >
                <v-icon v-text="`mdi-home${active ? '-circle' : ''}`" />
              </v-btn>
            </span>
          </template>
          <span>{{ m.lang.MAKE_HOMEPAGE }}</span>
        </v-tooltip>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          {{ m.lang.MAKE_HOMEPAGE }}
        </v-card-title>

        <v-card-text class="pt-4">
          <div class="body-1">
            {{ active ? m.lang.MAKE_HOMEPAGE_OFF : m.lang.MAKE_HOMEPAGE_ON }}
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn
            :color="active ? 'error' : 'success'"
            v-bind="{ loading }"
            @click="submit"
            >Confirm</v-btn
          >
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="dialog = false"> Cancel </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: {
    pageId: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      dialog: false,
      loading: false,
    }
  },

  computed: {
    active() {
      return this.$store.getters.settings &&
        this.$store.getters.settings.homepage === this.pageId
        ? true
        : false
    },
  },

  methods: {
    async submit() {
      this.loading = true
      this.$store.getters.settings.homepage = this.active ? '' : this.pageId
      await this.$app.post('settings', this.$store.getters.settings)
      this.loading = false
      this.dialog = false
    },
  },
}
</script>
