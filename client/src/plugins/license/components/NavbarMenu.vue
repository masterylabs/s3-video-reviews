<template>
  <!-- <div> -->
  <v-menu open-on-hover offset-y :value="show">
    <template v-slot:activator="{ on, attrs }">
      <v-avatar v-bind="attrs" v-on="on">
        <v-img :src="contact.avatar"></v-img>
      </v-avatar>
    </template>

    <license-card />
  </v-menu>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      contact: 'license/contact',
      show: 'license/show',
    }),
  },

  mounted() {},
}
</script>
