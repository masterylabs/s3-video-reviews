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
          <v-icon class="mr-1">mdi-plus</v-icon> Edit Folder
        </v-btn>
      </template>

      <add-folder>
        <template v-slot:top>
          <v-system-bar window dark color="secondary">
            <span class="ml-3">Edit Folder</span>
            <v-spacer></v-spacer>
            <v-icon @click="dialog = false">mdi-close</v-icon>
          </v-system-bar>
        </template>
      </add-folder>
    </v-dialog>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
    }
  },
}
</script>
