<template>
  <div class="text-center">
    <v-dialog v-model="data.dialog" width="500" persistent>
      <template v-slot:activator="{ on, attrs }">
        <v-btn depressed class="text-none" v-bind="attrs" v-on="on">
          <!-- <v-icon class="mr-1">mdi-plus</v-icon>  -->
          Add Folder
        </v-btn>
      </template>

      <add-folder>
        <template v-slot:top>
          <v-system-bar window dark color="secondary">
            <span class="ml-3">Add Folder</span>
            <v-spacer></v-spacer>
            <v-icon @click="data.dialog = false">mdi-close</v-icon>
          </v-system-bar>
        </template>
      </add-folder>
    </v-dialog>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      data: 'awsBuckets/folder',
    }),
  },
}
</script>
