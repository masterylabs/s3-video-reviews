<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ attrs }">
        <v-btn absolute right top icon v-bind="attrs" @click="open">
          <v-icon>mdi-dots-horizontal</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          <div>Edit Folder</div>
          <v-spacer />
        </v-card-title>

        <v-card-text>
          <v-text-field label="Name" v-model="form.name" />
          <v-alert color="orange lighten-4 caption"
            >Please Note: Changing folder name will effect the folder files URLs
          </v-alert>
        </v-card-text>

        <v-card-actions class="mx-0 px-6 pb-6 mt-n6">
          <v-btn :loading="deleting" @click="deleteFolder">
            Delete Folder
          </v-btn>
          <v-btn color="primary">Save Changes</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="close">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { getFolderName } from '../helpers'
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      confirm: false,
      dialog: false,
      loading: false,
      deleting: false,
      form: {
        name: '',
      },
    }
  },

  methods: {
    ...mapActions({
      deleteFolder2: 'awsBuckets/deleteFolder',
    }),
    open() {
      this.form.name = getFolderName(this.item.Key)
      this.dialog = true
      this.$emit('input', true)
    },
    close() {
      this.$emit('input', false)
      this.dialog = false
    },

    async saveChanges() {
      //
    },

    async deleteFolder() {
      this.deleting = true

      const ok = await this.deleteFolder2(this.item.Key)

      this.deleting = false
      if (ok) {
        this.$app.success('Folder deleted!')
        return (this.dialog = false)
      }

      this.$app.error('Unable to delete folder')
    },
  },
}
</script>
