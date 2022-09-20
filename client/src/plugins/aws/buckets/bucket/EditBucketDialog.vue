<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500" persistent>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          outlined
          class="text-none"
          v-bind="attrs"
          v-on="on"
        >
          <v-icon class="mr-1">mdi-plus</v-icon> Edit Bucket
        </v-btn>
      </template>

      <add-bucket>
        <template v-slot:top>
          <v-system-bar window dark color="secondary">
            <span class="ml-3">Edit Bucket</span>
            <v-spacer></v-spacer>
            <v-icon @click="dialog = false">mdi-close</v-icon>
          </v-system-bar>
        </template>
      </add-bucket>
    </v-dialog>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      dialog: false,
    }
  },

  computed: {
    ...mapGetters({
      // data: 'awsBuckets/addBucket',
    }),
  },
  created() {},
}
</script>
