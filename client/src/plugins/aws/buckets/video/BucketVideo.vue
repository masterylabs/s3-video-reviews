<template>
  <v-sheet min-height="200" class="overflow-hidden" style="position: relative">
    <!-- <v-system-bar dark color="secondary">
      <span>{{ item.Key }}</span>
    </v-system-bar> -->

    <v-card color="grey lighten-5">
      <div :style="`aspect-ratio: ${aspectRatio}`">
        <centered-layout>
          <m-loading-circle v-if="!videoReady" />
          <template v-if="!refreshing">
            <video
              v-show="videoReady"
              ref="video"
              v-bind="videoAttrs"
              @loadedmetadata="onVideoReady"
            ></video>
          </template>
        </centered-layout>
      </div>

      <v-fade-transition>
        <v-btn
          v-if="videoReady"
          fab
          absolute
          left
          top
          class="mt-10"
          color="secondary"
          @click.stop="drawer = !drawer"
        >
          <v-icon color="accent" large>mdi-menu</v-icon>
        </v-btn>
      </v-fade-transition>
    </v-card>

    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list-item>
        <v-list-item-avatar>
          <v-icon large>mdi-video</v-icon>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>{{ item.name }}</v-list-item-title>
        </v-list-item-content>

        <v-icon @click="refreshVideo">mdi-reload</v-icon>
      </v-list-item>

      <v-divider />

      <v-list dense>
        <v-list-item v-for="option in options" :key="option.value">
          <v-switch
            v-model="form[option.value]"
            :label="option.text"
            hide-details
          ></v-switch>
        </v-list-item>
      </v-list>

      <v-card-text>
        <v-select
          v-for="menu in selectMenus"
          :key="menu.value"
          v-model="form[menu.value]"
          :label="menu.text || menu.value"
          :items="menu.items"
          outlined
        />
        <v-select
          v-model="form.poster"
          label="Poster"
          :items="images"
          outlined
          clearable
          :loading="savingPoster"
          @change="onPoster"
        />
        <div style="position: relative">
          <v-textarea
            label="Embed Code"
            :value="code"
            readonly
            outlined
            hide-details
          />
          <v-btn small depressed absolute right top @click="doCopy">Copy</v-btn>
        </div>
      </v-card-text>
    </v-navigation-drawer>
  </v-sheet>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
// import copyToClipboardMixin from '@/mixins/copy-to-clipboard'
import { videoAspectRatiosForm } from '../lib/video'
export default {
  // mixins: [copyToClipboardMixin],
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      ready: false,
      videoReady: false,
      drawer: true,
      refreshing: false,
      savingPoster: false,
      src: '',
      videoSize: null,
      posterKey: '',
      form: {
        autoplay: false,
        controls: true,
        loop: false,
        muted: false,
        nodownload: false,
        preload: 'auto',
        aspectRatio: 'auto',
        poster: '',
      },
      options: [
        {
          text: 'Controls',
          value: 'controls',
        },
        {
          text: 'Autoplay',
          value: 'autoplay',
        },
        {
          text: 'Loop',
          value: 'loop',
        },
        {
          text: 'Muted',
          value: 'muted',
        },
        {
          text: 'No Download',
          value: 'nodownload',
        },
      ],
      selectMenus: [
        {
          value: 'preload',
          items: ['auto', 'metadata', 'none'],
        },
        videoAspectRatiosForm,
      ],
    }
  },

  computed: {
    ...mapGetters({
      isBucketPublic: 'awsBuckets/isBucketPublic',
      images: 'awsBuckets/imagesList',
      bucketName: 'awsBuckets/bucketName',
      videoPosters: 'awsBuckets/videoPosters',
    }),
    type() {
      return `video/${this.item.type}`
    },
    aspectRatio() {
      if (this.videoSize) {
        const calc = this.videoSize.width / this.videoSize.height
        const item = videoAspectRatiosForm.items.find((a) => a.calc === calc)
        if (item) {
          return item.value
        }
      }
      return `16 / 9`
    },

    code() {
      let str = `<video src="${this.item.url}" type="${this.type}" preload="${this.form.preload}"`

      if (this.form.poster) {
        str += ` poster="${this.form.poster}"`
      }
      if (this.form.nodownload) {
        str += ` controlsList="nodownload"`
        str += ` oncontextmenu="return false"`
      }

      this.options.forEach(({ value }) => {
        if (value !== 'nodownload' && this.form[value]) {
          str += ` ${value}`
        }
      })

      return `${str} style="width:100%;aspect-ratio:${this.aspectRatio};object-fit:cover"></video>`
    },

    videoAttrs() {
      return {
        src: this.src,
        type: this.type,
        controls: this.form.controls,
        autoplay: this.form.autoplay,
        muted: this.form.muted,
        loop: this.form.loop,
        preload: this.form.preload,
        poster: this.form.poster,
        controlsList: this.form.nodownload ? 'nodownload' : '',
        style: `aspect-ratio: ${this.aspectRatio}`,
      }
    },
  },

  methods: {
    ...mapActions({
      getDownloadUrl: 'awsBuckets/getDownloadUrl',
      onVideoPoster: 'awsBuckets/onVideoPoster',
    }),
    doCopy() {
      // this.copyToClipboard(this.code)
      this.$emit('clipboard', this.code)
    },

    onVideoReady() {
      const video = this.$refs.video

      if (video.videoWidth) {
        this.videoSize = {
          width: video.videoWidth,
          height: video.videoHeight,
        }
      }
      this.videoReady = true
    },

    async getSource() {
      if (this.isBucketPublic) {
        this.src = this.item.url
      } else {
        this.src = await this.getDownloadUrl(this.item.Key)
      }
    },

    async refreshVideo() {
      this.videoReady = false
      this.refreshing = true
      await this.getSource()
      this.refreshing = false
    },

    async onPoster(url) {
      this.savingPoster = true
      await this.onVideoPoster({ Key: this.item.Key, url })
      this.savingPoster = false
    },
  },

  async created() {
    await this.getSource()
    this.ready = true

    this.posterKey = this.bucketName + this.item.Key + '_poster'

    const poster = this.videoPosters.find(({ Key }) => Key === this.item.Key)
    if (poster) {
      this.form.poster = poster.url
    }
    this.drawer = true
  },
}
</script>

<style>
video {
  max-width: 100%;
  vertical-align: bottom;
}
video[poster] {
  object-fit: cover;
  width: 100%;
  max-width: 100%;
}
</style>
