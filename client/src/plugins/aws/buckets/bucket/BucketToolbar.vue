<template>
  <div>
    <v-toolbar rounded="lg" elevation="3">
      <v-icon
        size="26"
        class="mr-1"
        :color="data.meta.color || 'accent'"
        @click="edit = true"
        >mdi-{{ data.meta.icon || 'bucket' }}
      </v-icon>

      <v-toolbar-title>
        <m-tooltip :value="data.name" :disabled="!data.meta.displayName">
          {{ data.meta.displayName || data.name }}
        </m-tooltip>
        <aws-buckets-public-status-label btn-class="mt-n4" />
      </v-toolbar-title>

      <aws-buckets-files-search />
      <v-spacer />

      <bucket-objects-total />

      <website-switch v-if="websiteAccess" />
      <aws-buckets-public-bucket-switch class="ml-5" />
      <!-- <v-divider vertical class="ml-4"></v-divider> -->
      <!-- <aws-buckets-overwrite-switch class="ml-5 mr-1" /> -->

      <m-tooltip value="Edit">
        <v-btn icon class="mx-2" @click="edit = true">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </m-tooltip>
      <add-folder-dialog />
      <aws-buckets-add-file-btn class="ml-2" />
    </v-toolbar>

    <m-dialog v-model="edit" title="Edit Bucket">
      <edit-bucket :item="data" @saved="edit = false" @deleted="onDeleted" />
    </m-dialog>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      edit: false,
    }
  },
  computed: {
    ...mapState({
      awsBuckets: 'awsBuckets',
    }),
    ...mapGetters({
      data: 'awsBuckets/data',
      meta: 'awsBuckets/meta',
      uploads: 'awsBuckets/uploads',
      files: 'awsBuckets/files',
      folders: 'awsBuckets/folders',
      websiteUrl: 'awsBuckets/websiteUrl',
      // filesForm: 'awsBuckets/filesForm',
      websiteAccess: 'websiteAccess',
    }),
  },

  methods: {
    ...mapActions({
      loadItem: 'awsBuckets/loadItem',
      clearItem: 'awsBuckets/clearItem',
      deleteFolder: 'awsBuckets/deleteFolder',
    }),
    onDeleted() {
      this.$router.replace({ name: 'home' })
    },
  },
}
</script>
