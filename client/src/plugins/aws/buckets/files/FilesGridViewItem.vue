<template>
  <div>
    <v-hover v-slot="{ hover }">
      <v-card :loading="creatingThumb">
        <v-system-bar color="secondary" dark>
          <span class="text-truncate">{{ item.name }}</span>
          <v-spacer />
          <span class="text-no-wrap accent--text">{{ item.Size | size }}</span>
        </v-system-bar>

        <v-sheet height="200" color="grey lighten-4">
          <v-container fill-height>
            <v-row align="center" justify="center">
              <v-img
                v-if="thumb"
                ref="thumb"
                :src="thumb"
                contain
                style="max-width: 100%; max-height: 200px"
                @load="onThumbLoad"
              >
                <v-fade-transition>
                  <div
                    v-if="ready && canCreateThumb"
                    class="pr-2 pt-2 text-right"
                  >
                    <m-tooltip value="Generate Thumbnail">
                      <v-btn
                        :loading="creatingThumb"
                        icon
                        dark
                        style="background: rgba(0, 0, 0, 0.4)"
                        @click="onCreateThumb"
                      >
                        <v-icon>mdi-message-image</v-icon></v-btn
                      >
                    </m-tooltip>
                  </div>
                </v-fade-transition>
              </v-img>
              <div v-else class="text-center">
                <div
                  class="text-h2 font-weight-bold secondary--text text-uppercase"
                >
                  {{ item.type }}
                </div>
                <div
                  class="text-truncate body-1 font-weight-medium"
                  style="max-width: 200px"
                >
                  {{ item.name }}
                </div>
              </div>
            </v-row>
          </v-container>

          <v-expand-transition>
            <v-row
              v-if="isThumb && !hover"
              align="center"
              justify="center"
              no-gutters
              style="
                position: absolute;
                left: 0;
                top: 24px;
                width: 100%;
                height: 200px;
                background: rgba(0, 0, 0, 0.5);
              "
            >
              <div class="white--text text-h3 font-weight-bold text-uppercase">
                THUMB
              </div>
            </v-row>
          </v-expand-transition>
        </v-sheet>

        <v-card-actions>
          <template v-if="!isDeleteConfirm">
            <m-tooltip
              v-for="action in actions"
              :key="action.icon"
              :value="action.text"
            >
              <v-btn
                icon
                class="mr-2"
                :loading="loading === action.value"
                :disabled="disabled[action.value]"
                @click="action.click"
              >
                <v-icon>mdi-{{ action.icon || 'pencil' }}</v-icon>
              </v-btn>
            </m-tooltip>

            <m-tooltip v-if="canEdit" :value="editValue.text">
              <v-btn icon @click="onEdit">
                <v-icon> mdi-{{ editValue.icon }} </v-icon>
              </v-btn>
            </m-tooltip>
          </template>

          <v-spacer />
          <aws-buckets-files-duplicate-item
            v-if="!isDeleteConfirm"
            :item-key="item.Key"
          />
          <v-divider vertical class="mx-1"></v-divider>

          <aws-buckets-files-delete-item
            v-model="isDeleteConfirm"
            :item-key="item.Key"
          />
        </v-card-actions>
      </v-card>
    </v-hover>

    <v-dialog v-if="canEdit" v-model="dialog" width="700">
      <v-card>
        <v-system-bar dark color="secondary">
          <span>{{ item.name }}</span>
          <v-spacer />
          <v-icon @click="dialog = false">mdi-close</v-icon>
        </v-system-bar>
        <buckets-file-editor
          v-if="item.contentType === 'text'"
          v-bind="{ item }"
          @clipboard="onDialogClipboard"
        />
        <buckets-image-editor
          v-else-if="item.contentType === 'image'"
          v-bind="{ item }"
          @clipboard="onDialogClipboard"
        />

        <bucket-video
          v-else-if="item.contentType === 'video'"
          v-bind="{ item }"
          @clipboard="onDialogClipboard"
        />
        <bucket-audio
          v-else-if="item.contentType === 'audio'"
          v-bind="{ item }"
          @clipboard="onDialogClipboard"
        />
      </v-card>
    </v-dialog>

    <buckets-file-editor v-if="codeEditor" v-bind="{ item }" fullscreen>
      <template v-slot:toolbar-append>
        <v-btn icon class="ml-4" @click="codeEditor = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </buckets-file-editor>
  </div>
</template>

<script>
import prettyBytes from 'pretty-bytes'
import { mapGetters, mapActions } from 'vuex'
import copyToClipboardMixin from '@/mixins/copy-to-clipboard'
import { isThumb } from '../helpers'

export default {
  mixins: [copyToClipboardMixin],
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      isDeleteConfirm: false,
      dialog: false,
      ready: false,
      more: true,
      codeEditor: false,
      duplicating: false,
      action: '',
      thumb: '',
      isCustomThumb: false,
      creatingThumb: false,
      // createThumbOnLoad: false,
      loading: '',
      itemSize: {
        width: '',
        height: '',
      },
      editItems: {
        text: {
          text: 'Code Editor',
          icon: 'code-tags',
          addon: 'editor',
        },
        image: {
          text: 'Image Compressor',
          icon: 'tune-vertical',
          addon: 'compressor',
        },
        video: {
          text: 'Video Tools',
          icon: 'cogs',
          addon: 'video',
        },
        audio: {
          text: 'Audio Tools',
          icon: 'cogs',
          addon: 'audio',
        },
      },
      actions: [
        {
          text: 'Copy URL',
          icon: 'link',
          value: 'copy',
          click: this.copyUrl,
        },
        {
          text: 'Open',
          icon: 'open-in-new',
          value: 'open',
          click: this.openUrl,
        },
        {
          text: 'Download',
          icon: 'download',
          value: 'download',
          click: this.downloadFile,
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      isBucketPublic: 'awsBuckets/isBucketPublic',
      access: 'access',
      images: 'awsBuckets/imagesList',
      thumbKey: 'awsBuckets/thumbKey',
      settings: 'settings',
    }),

    isThumb() {
      return isThumb(this.item.Key)
    },

    editValue() {
      const type = this.item.contentType
      if (this.editItems[type]) {
        return this.editItems[type]
      }
      return false
    },

    canEdit() {
      if (!this.editValue) {
        return false
      }

      if (this.access.premium) {
        return true
      }

      if (this.editValue.access && this.access[this.editValue.access]) {
        return true
      }

      return false
    },

    title() {
      if (this.itemSize.width) {
        return `${this.itemSize.width}x${this.itemSize.height}`
      }
      return ''
    },
    disabled() {
      return {
        open: !this.isBucketPublic,
      }
    },

    canCreateThumb() {
      // return !this.isThumb
      // thumb is 10191
      if (this.isThumb || this.item.thumb || this.item.Size <= 15000) {
        return false
      }

      return this.item.contentType === 'image'
    },
  },

  methods: {
    ...mapActions({
      downloadObject: 'awsBuckets/downloadObject',
      downloadFile2: 'awsBuckets/downloadFile',
      getDownloadUrl: 'awsBuckets/getDownloadUrl',
      createThumb: 'awsBuckets/createThumb',
    }),
    // createThumb,

    onEdit() {
      if (this.item.contentType === 'text') {
        this.codeEditor = true
      } else {
        this.dialog = true
      }
    },

    onThumbLoad() {
      if (this.$refs.thumb) {
        this.itemSize.width = this.$refs.thumb.naturalWidth
        this.itemSize.height = this.$refs.thumb.naturalHeight
      }
    },
    copyUrl() {
      this.copyToClipboard(this.item.url)
    },
    openUrl() {
      window.open(this.item.url)
    },
    async downloadFile() {
      this.loading = 'download'
      const download = await this.downloadFile2(this.item.Key)

      if (!download) {
        return this.$app.error('Unable download')
      }

      setTimeout(() => {
        this.loading = ''
      }, 1000)
    },

    onDialogClipboard(value) {
      this.dialog = false

      setTimeout(() => {
        this.copyToClipboard(value)

        setTimeout(() => {
          this.dialog = true
        }, 1)
      }, 1)
    },

    async loadThumb() {
      const { url, Key } = this.item.thumb
      if (this.isBucketPublic) {
        this.thumb = url
      } else {
        this.thumb = await this.getDownloadUrl(Key)
      }
    },

    async onCreateThumb() {
      this.creatingThumb = true
      const success = await this.createThumb(this.item.Key)
      this.creatingThumb = false

      if (this.item.thumb) {
        await this.loadThumb()
      }

      if (success) {
        this.$app.success('Thumb created!')
      } else {
        this.$app.error('Unable to create thumb')
      }
    },

    async loadSelfAsThumb() {
      if (this.isBucketPublic) {
        this.thumb = this.item.url
      } else {
        this.thumb = await this.getDownloadUrl(this.item.Key)
      }
    },
  },

  async created() {
    if (this.item.thumb) {
      await this.loadThumb()
    } else if (this.item.contentType === 'image') {
      if (this.settings.auto_thumbs && !this.isThumb) {
        await this.onCreateThumb()
      }

      await this.loadSelfAsThumb()
    }

    this.ready = true
  },
  filters: {
    size(value) {
      return prettyBytes(value)
    },
  },
}
</script>
