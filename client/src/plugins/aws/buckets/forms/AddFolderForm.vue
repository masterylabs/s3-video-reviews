<template>
  <div>
    <v-btn depressed class="font-weight-medium text-none" @click="dialog = true"
      >Add Folder</v-btn
    >
    <aws-buckets-dialog v-model="dialog" title="Add Folder">
      <v-text-field
        v-model="form.name"
        label="Folder Name"
        placeholder="my-new-folder"
        autofocus
      ></v-text-field>
      <v-expand-transition>
        <div v-if="more" class="mt-n3">
          <v-text-field v-model="form.meta.displayName" label="Display Name" />
          <aws-buckets-color-field v-model="form.meta.color" />
          <aws-buckets-icon-field
            v-model="form.meta.icon"
            default-value="folder"
            class="mb-5"
          />
        </div>
      </v-expand-transition>

      <template v-slot:actions>
        <v-btn
          v-bind="{ loading, disabled: !form.name }"
          @click="submit"
          color="primary"
        >
          Add Now
        </v-btn>
        <v-spacer />

        <v-btn depressed small @click="more = !more">More Options</v-btn>
      </template>
    </aws-buckets-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
const baseForm = {
  name: '',
  meta: {
    displayName: '',
    color: '',
    icon: '',
  },
}
export default {
  data() {
    return {
      dialog: false,
      more: false,
      loading: false,
      form: {
        ...baseForm,
      },
    }
  },
  methods: {
    ...mapActions({
      createFolder: 'awsBuckets/createFolder',
    }),
    async submit() {
      this.loading = true
      const success = await this.createFolder(this.form)

      this.loading = false

      if (success) {
        this.form = { ...baseForm }
        this.dialog = false
        this.$app.success('Folder Added!')
      } else {
        this.$app.error('Unable to add folder')
      }
    },
  },
}
</script>
