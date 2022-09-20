<template>
  <div>
    <v-container v-if="ready">
      <v-expand-transition>
        <v-row
          v-if="websiteAccess && showWebsite"
          align="center"
          justify="space-between"
          no-gutters
          class="my-3 mx-2"
        >
          <v-spacer />
          <website-url />
        </v-row>
      </v-expand-transition>
      <bucket-toolbar />

      <v-row
        no-gutters
        align="center"
        justify="space-between"
        class="mb-2 mt-1"
      >
        <bucket-crumbs />
        <v-spacer />
        <aws-buckets-files-total />
        <v-switch
          v-model="filesForm.showThumbs"
          label="Show Thumbs"
          hide-details
          class="mt-0 ml-3"
        />
        <aws-buckets-overwrite-switch class="ml-5 mr-4" />
        <aws-buckets-files-refresh-btn />
        <m-btn-select
          v-model="filesForm.view.value"
          :items="filesForm.view.options"
          large
          @input="onViewChange"
        />
      </v-row>

      <!-- Folders  -->
      <v-expand-transition>
        <v-row v-if="folders.length" class="mb-3">
          <v-col
            v-for="item in folders"
            cols="12"
            sm="6"
            md="4"
            lg="3"
            :key="item.Key"
          >
            <grid-folder v-bind="{ item }" />
          </v-col>
        </v-row>
      </v-expand-transition>

      <!-- Table View  -->
      <v-expand-transition>
        <v-card
          v-if="filesForm.view.value === 'table'"
          rounded="lg"
          elevation="3"
        >
          <v-card-text>
            <aws-buckets-files :is-drag-over="isDragOver" />
          </v-card-text>
        </v-card>
      </v-expand-transition>

      <!-- Grid View  -->
      <v-expand-transition>
        <aws-buckets-files-grid-view v-if="filesForm.view.value === 'grid'" />
      </v-expand-transition>

      <aws-buckets-upload-progress class="mt-6" />

      <div class="text-center my-16">
        <h3 class="text-h3 grey--text text--lighten-2">
          Drag And Drop To Add Files
        </h3>
      </div>
    </v-container>

    <aws-buckets-drag-overlay v-if="isDragOver" />

    <m-dialog v-if="ready" v-model="edit" :title="data.name">
      <edit-bucket
        v-bind="{ item: data }"
        @saved="edit = false"
        @deleted="onDeleted"
      />
    </m-dialog>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import dragAndDropMixin from './mixins/bucket-drag-drop'
export default {
  mixins: [dragAndDropMixin],

  data() {
    return {
      ready: false,
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
      color: 'awsBuckets/color',
      showWebsite: 'awsBuckets/showWebsite',
      websiteAccess: 'websiteAccess',
      filesForm: 'awsBuckets/filesForm',
      path: 'awsBuckets/path',
      // thumbs: 'awsBuckets/thumbs',
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
    onViewChange(value) {
      this.$localforage.setItem(`${this.data.name}${this.path}_view`, value)
    },

    async setView() {
      const value = await this.$localforage.getItem(
        `${this.data.name}${this.path}_view`
      )

      if (value) {
        this.filesForm.view.value = value
        //
      }
    },
  },

  beforeDestroy() {
    this.clearItem()
  },

  async mounted() {
    const success = await this.loadItem(this.$route.params.id)

    if (!success) {
      return this.$router.push({ name: 'home' })
    }

    this.ready = true
  },

  watch: {
    path() {
      this.setView()
    },
  },
}
</script>
