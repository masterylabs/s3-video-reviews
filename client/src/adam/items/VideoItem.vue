<template>
  <adam-edged-item :value="edged" :theme="theme">
    <m-player
      ref="player"
      v-if="src"
      v-bind="{
        ...player,
        src,
        poster,
        rounded,
        color: color ? color : theme && theme.color ? theme.color : '',
        preview: preview && !isPreview,
        noControls: noControls && !isPreview,
        noPause: noPause && !isPreview,
        id: id,
      }"
      emit-current-time
      @current-time="onCurrentTime"
      @play="onPlay"
    />
  </adam-edged-item>
</template>

<script>
// import { makeEdged, clearEdged } from '../helpers/edged'
// import itemEdgedMixin from '../mixins/item-edged'
export default {
  // mixins: [itemEdgedMixin],
  props: {
    edged: Boolean,
    isPreview: Boolean,
    preview: Boolean,
    noControls: Boolean,
    noPause: Boolean,
    id: {
      type: String,
      required: true,
    },

    src: {
      type: String,
      default: null,
    },
    poster: {
      type: String,
      default: null,
    },
    color: {
      type: String,
      default: null,
    },
    elevation: {
      type: Number,
      default: null,
    },
    grayscale: {
      type: Number,
      default: null,
    },
    rounded: {
      type: String,
      default: null,
    },
    theme: {
      type: Object,
      default() {
        return {}
      },
    },
  },

  data() {
    return {
      devMain: {},
    }
  },

  computed: {
    player() {
      const item = { class: [], style: { overflow: 'hidden' } }

      if (this.elevation) {
        item.class.push(`elevation-${this.elevation}`)
      }

      if (this.rounded) {
        item.class.push(`rounded-${this.rounded}`)
      }

      if (this.grayscale) {
        item.style.filter = `grayscale(${this.grayscale}%)`
      }
      if (this.rotate) {
        item.style.transform = 'rotate(40deg)'
      }

      return item
    },

    isEdged() {
      return this.edged && !this.$vuetify.breakpoint.smAndDown
    },
  },

  methods: {
    onCurrentTime(ct) {
      this.$emit('message', ['current-time', { id: this.id, ct }])

      //
    },

    onPlay() {
      if (!this.isPreview) {
        this.pauseOtherVideos()
      }
    },

    pauseOtherVideos() {
      if (window.QUICK_VIDEO_OFFERS_VIDEOS) {
        window.QUICK_VIDEO_OFFERS_VIDEOS.forEach((v) => {
          if (
            v.id !== this.id &&
            ['playing', 'play', 'seek', 'seeking'].includes(v.playerState)
          ) {
            v.pause()
          }
        })
      }
    },
  },

  mounted() {
    if (!this.isPreview && window.QUICK_VIDEO_OFFERS_VIDEOS && this.src) {
      window.QUICK_VIDEO_OFFERS_VIDEOS.push(this.$refs.player)
    }
  },
}
</script>
