<template>
  <div>
    <v-btn
      depressed
      :loading="loading"
      :disabled="livePreviewActive"
      class="hidden-sm-and-down"
      @click="open"
    >
      Preview
    </v-btn>
    <v-btn
      depressed
      :loading="loading"
      :color="livePreviewActive ? 'success' : ''"
      class="ml-2"
      @click="toggleLivePreview"
    >
      <v-icon class="mr-1">mdi-dock-window</v-icon>
      Live Preview
    </v-btn>
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-toolbar dark>
        <v-toolbar-title>Preview</v-toolbar-title>
        <v-spacer />
        <v-btn-toggle v-model="view">
          <v-btn
            v-for="item in items"
            class="is-active"
            :key="item.value"
            :value="item.value"
          >
            <v-icon v-text="`mdi-${item.icon}`" class="mr-1" />
            {{ item.text }}
          </v-btn>
        </v-btn-toggle>

        <v-spacer />
        <v-btn icon @click="updatePreview">
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </v-toolbar>

      <div class="preview-container grey darken-3 text-center">
        <v-expand-transition>
          <v-container v-if="dialog" fill-height>
            <v-row align="center" justify="center">
              <!-- src="http://localhost:8080/live" -->
              <iframe
                ref="iframe"
                :src="previewUrl"
                frameborder="0"
                class="preview-frame mx-auto elevation-12"
                :class="[
                  `preview-${item.value}`,
                  item.value !== 'desktop' ? 'rounded-lg' : '',
                ]"
                :style="
                  item.value === 'desktop'
                    ? 'min-width:960px'
                    : `height:${item.height}px;width:${item.width}px`
                "
                scroll
                @load="onIframeLoad"
              ></iframe>
            </v-row>
          </v-container>
        </v-expand-transition>
      </div>

      <v-btn
        fab
        absolute
        top
        right
        color="error"
        style="top: 80px; right: 40px"
        @click="dialog = false"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: {
    pageId: {
      type: [String, Number],
      required: true,
    },
  },

  data() {
    return {
      loading: false,
      dialog: false,
      view: 'desktop',
      livePreviewWindow: null,
      livePreviewActive: false,
      watchStarted: false,
      items: [
        {
          text: 'Desktop',
          value: 'desktop',
          icon: 'monitor',
          mt: 0,
        },
        {
          text: 'Tablet',
          value: 'tablet',
          icon: 'tablet-android',
          width: 768,
          height: 1024,
        },
        {
          text: 'Mobile',
          value: 'mobile',
          icon: 'cellphone',
          width: 400,
          height: 667,
        },
      ],
    }
  },
  computed: {
    ...mapGetters({
      hasChanges: 'adam/hasChanges',
      livePreviewData: 'adam/livePreviewData',
    }),
    item() {
      return this.items.find(({ value }) => value === this.view)
    },

    previewUrl() {
      // local debug
      if (window.location.host === 'localhost:8080') {
        return 'http://localhost:8080/preview.html'
      }

      return `${this.$store.getters.config.app_url}/admin/preview/${this.pageId}`
    },
  },

  methods: {
    ...mapActions({
      save: 'adam/save',
      // toggleLivePreview: 'adam/toggleLivePreview'
    }),

    onIframeLoad() {
      this.updatePreview()
    },

    updatePreview() {
      const previewContent = this.livePreviewData
      const msg = JSON.stringify({ previewContent })

      if (this.livePreviewActive) {
        if (this.livePreviewWindow.closed) {
          return this.onLivePreviewClosed()
        }
        this.livePreviewWindow.postMessage(msg, '*')
      } else if (this.dialog) {
        this.$refs.iframe.contentWindow.postMessage(msg, '*')
      }
    },

    onLivePreviewClosed() {
      this.livePreviewActive = false
      this.livePreviewWindow = null
    },

    onPreviewClosed() {
      if (this.livePreviewActive) {
        this.onLivePreviewClosed()
      }
    },

    toggleLivePreview() {
      if (this.livePreviewActive) {
        this.livePreviewWindow.close()
        return this.onLivePreviewClosed()
      }

      this.maybeStartWatch()

      let width = 1115 // screen.width / 2
      let height = 1260 // screen.height
      const left = screen.width / 2
      let top = (screen.height - height) / 2
      if (top < 0) top = 0

      this.livePreviewWindow = window.open(
        this.previewUrl,
        'LivePreview',
        `width=${width},height=${height},left=${left},top=${top},status=0,toolbar=0`
      )
      this.livePreviewActive = true
    },

    maybeStartWatch() {
      if (this.watchStarted) {
        return
      }
      this.watchStarted = true

      this.$watch(
        'livePreviewData',
        () => {
          this.updatePreview()
        },
        { deep: true }
      )
    },

    async open() {
      this.dialog = true

      // Back up
      setTimeout(() => {
        if (!this.dialog) {
          return
        }

        this.updatePreview()

        setTimeout(() => {
          if (!this.dialog) {
            return
          }

          this.updatePreview()
        }, 6000)
      }, 3000)
    },
  },

  beforeDestroy() {
    if (this.livePreviewActive) {
      this.toggleLivePreview()
    }
  },

  beforeMount() {
    window.addEventListener(
      'message',
      (event) => {
        //
        if (event.data === 'preview_listening') {
          this.updatePreview()
        }

        if (event.data === 'preview_closed') {
          this.onPreviewClosed()
        }
      },
      false
    )
  },

  // mounted() {
  //   this.toggleLivePreview()
  // },
}
</script>

<style scoped>
.preview-container {
  position: fixed;
  left: 0px;
  top: 60px;
  width: 100%;
  height: calc(100% - 60px);
  overflow: auto;
}
.preview-frame {
  transition: 500ms width ease-in;
}
.preview-desktop {
  position: fixed;
  width: calc(100%);
  height: calc(100% - 60px);
}
</style>
