<template>
  <v-card width="400" elevation="12">
    <v-card-text class="text-center">
      <v-row align="center" justify="center" no-gutters class="mb-4 mt-3">
        <div class="text-h5 success--text font-weight-medium">
          {{ product.name }}
        </div>
        <v-icon color="success" class="ml-4 mr-n12" size="40"
          >mdi-certificate</v-icon
        >
      </v-row>
      <div
        v-for="addon in addons"
        :key="addon.value"
        class="success lighten-5 body-1 mb-1"
      >
        {{ addon.text }}
        <v-icon class="ml-2 mr-n4">mdi-check</v-icon>
      </div>

      <br />
      <div class="body-2 text-center font-italic">{{ _('LICENSE_TO') }}</div>
      <div class="text-h6 text-center">{{ contact.name }}</div>
    </v-card-text>

    <v-divider></v-divider>
    <v-card-actions>
      <v-btn
        @click="toggleUpdateDialog"
        color="primary"
        text
        class="mx-auto my-2"
      >
        {{ _('UPDATE_LICENSE') }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      contact: 'license/contact',
      product: 'license/product',
      addons: 'license/addons',
    }),
  },

  methods: {
    ...mapActions({
      toggleUpdateDialog: 'license/toggleUpdateDialog',
    }),
  },

  mounted() {},
}
</script>
