<template>
  <div>
    <aws-buckets-color-field
      v-model="meta.color"
      class="mx-n2"
      @input="onChange"
    />
    <aws-buckets-icon-field
      v-model="meta.icon"
      default-value="folder"
      @input="onChange"
      class="mb-5 mx-n2"
    />
    <v-text-field
      v-model="meta.displayName"
      label="Display Name"
      :placeholder="item.name"
      @input="onChange"
    />

    <m-delete-btn
      depressed
      icon
      justify="end"
      :loading="deleting"
      @confirm="deleteItem"
      class="mt-6"
    >
      Delete Folder
    </m-delete-btn>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import autoSaveMixin from '../mixins/auto-save-bucket'
export default {
  mixins: [autoSaveMixin],
  props: {
    itemKey: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      deleting: false,
    }
  },

  computed: {
    ...mapGetters({
      folders: 'awsBuckets/folders',
      folderMeta: 'awsBuckets/folderMeta',
    }),
    item() {
      return this.folders.find((a) => a.Key === this.itemKey)
    },
    meta() {
      return this.folderMeta.find((a) => a.Key === this.itemKey) || {}
    },
  },

  methods: {
    ...mapActions({
      deleteFolder: 'awsBuckets/deleteFolder',
    }),
    onChange() {
      this.autoSave(this.$route.params.id)
    },

    async deleteItem() {
      this.deleting = true
      await this.deleteFolder(this.itemKey)

      this.deleting = false
    },
  },
}
</script>
