<template>
  <v-card height="180" @click="select">
    <v-system-bar height="30" color="secondary" dark>
      <span class="text-truncate">{{ item.Key | fileName }}</span>
    </v-system-bar>

    <v-img
      v-if="item.contentType === 'image'"
      :src="item.thumbUrl || item.url"
      height="150"
      contain
    >
      <!-- <div class="delete-media-btn-container rounded-circle">
        <v-hover v-model="overDelete">
          <m-delete-btn
            icon
            dark
            emit-delete
            @delete="deleteImage(item)"
          ></m-delete-btn>
        </v-hover>
      </div> -->
    </v-img>
    <div v-else class="text-center">
      <v-icon size="100" class="mt-5">
        mdi-{{ icons[item.contentType] ? icons[item.contentType] : 'file' }}
      </v-icon>
    </div>

    <div class="delete-media-btn-container rounded-circle">
      <v-hover v-model="overDelete">
        <m-delete-btn
          icon
          dark
          emit-delete
          @delete="deleteImage(item)"
        ></m-delete-btn>
      </v-hover>
    </div>
  </v-card>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
// import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
// import { GetObjectCommand } from '@aws-sdk/client-s3'

// import { consoleInfo } from 'vuetify/lib/util/console'

export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isDragOver: true,
      overDelete: false,
      //   url: '',
      icons: {
        zip: 'folder-zip',
        video: 'youtube',
        other: 'file',
      },
    }
  },

  filters: {
    fileName(str) {
      return str.split('/').pop()
    },
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

      getBucket: 'adam/getBucket',
    }),
    select() {
      if (this.overDelete) return

      this.callMediaSelect(this.item.url)

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
}
</script>

<style lang="scss" scoped>
.delete-media-btn-container {
  position: absolute;
  right: 10px;
  bottom: 10px;
  background: rgba(0, 0, 0, 0.5);
  padding: 8px;
}
</style>
