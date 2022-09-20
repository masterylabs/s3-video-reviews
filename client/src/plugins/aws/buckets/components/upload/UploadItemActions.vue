<template>
  <!-- <v-row> -->
  <v-btn @click="clearItem" icon>
    <v-icon>mdi-close</v-icon>
  </v-btn>
  <!-- </v-row> -->
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: {
    itemKey: {
      type: String,
      required: true,
    },
  },

  computed: {
    ...mapGetters({
      //
    }),
  },

  methods: {
    ...mapActions({
      removeUpload: 'awsBuckets/removeUpload',
    }),
    clearItem() {
      this.removeUpload(this.itemKey)
    },
  },
}
</script>
