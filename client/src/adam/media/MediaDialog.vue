<template>
  <v-dialog v-model="media.dialog" width="900" persistent @input="onDialog">
    <v-card min-height="700">
      <adam-media-drag-drop>
        <v-toolbar dense flat color="grey lighten-3">
          <v-toolbar-title>Media</v-toolbar-title>
          <v-spacer />
          <v-btn
            icon
            :disabled="!media.ready"
            :loading="media.ready && media.loading"
            @click="refreshMedia"
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-btn icon @click="media.dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text class="py-7">
          <v-row>
            <v-col
              v-for="item in mediaItems"
              :key="item.Key"
              cols="12"
              sm="6"
              md="4"
              lg="3"
            >
              <adam-media-item v-bind="{ item }" />
            </v-col>
          </v-row>
          <div
            class="text-center mt-6 body-1 text-uppercase grey--text text--darken-2"
          >
            <div class="mb-10 mt-13">
              <adam-media-file-input />
            </div>
            <div>Drag and drop files here</div>
          </div>
        </v-card-text>
      </adam-media-drag-drop>
      <v-overlay
        absolute
        v-if="media.loading || !media.ready || media.uploading"
      >
        <v-progress-circular indeterminate size="100"></v-progress-circular>
      </v-overlay>
      <!-- mediaItems: {{ mediaItems }} -->
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      isDragOver: true,
      overDelete: false,
    }
  },

  computed: {
    ...mapGetters({
      media: 'adam/media',
      mediaItems: 'adam/mediaItems',
      prefix: 'adam/bucketUrlPrefix',
    }),
  },

  methods: {
    ...mapActions({
      loadMedia: 'adam/loadMedia',
      openMedia: 'adam/openMedia',
      refreshMedia: 'adam/refreshMedia',
      deleteImage: 'adam/deleteMediaItem',
      callMediaSelect: 'adam/callMediaSelect',
      clearMedia: 'adam/clearMedia',
    }),
    select(url) {
      if (this.overDelete) return

      this.callMediaSelect(url)
      // this.$emit('input', url)
      this.media.dialog = false
    },

    onDialog(v) {
      if (v) {
        this.openMedia()
      } else {
        this.media.dialog = false
      }
    },
  },

  beforeDestroy() {
    this.clearMedia()
  },
}
</script>

<style lang="scss" scoped>
.delete-media-btn-container {
  position: absolute;
  right: 20px;
  bottom: 20px;
  background: rgba(0, 0, 0, 0.5);
  padding: 8px;
}
</style>
