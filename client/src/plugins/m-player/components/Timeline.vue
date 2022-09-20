<template>
  <div class="m-player-timeline-container" :class="containerClass">
    <div
      ref="timeline"
      class="m-player-timeline"
      :style="`height:${height}px;line-height:${height}px`"
      v-on:click="onClick"
      @mouseenter="over = true"
      @mouseleave="over = false"
      @mousemove="onMove"
    >
      <!-- Backgrounds  -->
      <div class="m-player-timeline-bg" :style="`background:${this.color}`" />

      <div
        class="m-player-timeline-ct-bg"
        :style="`background:${this.color};width:${progress * 100}%`"
      />

      <v-fade-transition>
        <div
          v-if="over"
          class="m-player-timeline-preview-bg"
          :style="`background:${this.color};width:${previewProgress * 100}%`"
        ></div>
      </v-fade-transition>

      <!-- Markers  -->
      <div
        class="m-player-timeline-ct-marker"
        :style="`width:${progress * 100}%`"
      />

      <v-fade-transition>
        <div
          v-show="over"
          class="m-player-timeline-preview-marker"
          :style="`width:${previewProgress * 100}%`"
        />
      </v-fade-transition>

      <!-- Texts  -->
      <!-- Current Time Text  -->
      <v-fade-transition>
        <div
          v-show="showCurrentTime"
          ref="currentTimeText"
          class="m-player-timeline-ct-text"
          :style="`width:${progress * 100}%`"
        >
          {{ getCurrentTime | mt }}
        </div>
      </v-fade-transition>

      <!-- Preview Text  -->
      <div
        v-show="over"
        ref="previewText"
        class="m-player-timeline-preview-text"
        :style="`width:${previewProgress * 100}%`"
      >
        <v-fade-transition>
          <span> {{ previewTime | mt }}</span>
        </v-fade-transition>
      </div>

      <!-- Duration Text  -->
      <div ref="durationText" class="m-player-timeline-dur">
        <v-fade-transition>
          <span v-show="showDuration">
            {{ getDuration | mt }}
          </span>
        </v-fade-transition>
      </div>
    </div>
  </div>
</template>

<script>
import mediaTime from '@/_/helpers/media-time'
export default {
  props: {
    dark: Boolean,
    duration: {
      type: Number,
      default: 0,
    },
    currentTime: {
      type: Number,
      default: 0,
    },
    start: {
      type: Number,
      default: 0,
    },
    end: {
      type: Number,
      default: 0,
    },
    color: {
      type: String,
      default: '',
    },
    height: {
      type: [String, Number],
      required: true,
    },
    playerState: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      over: false,
      offsetX: 0,
      previewProgress: 0,
      clicked: false,
      durTextWidth: 90,

      ctTextWidth: 90,
      overCurrentTime: false,
      overDurText: false,
      ctOverDurText: false,
    }
  },

  computed: {
    showCurrentTime() {
      return !this.over || !this.overCurrentTime
    },
    showDuration() {
      return !(this.ctOverDurText || this.overDurText)
    },
    getDuration() {
      let dur = this.end ? this.end : this.duration

      if (this.start) dur = dur - this.start

      return dur
    },

    getCurrentTime() {
      if (this.playerState === 'ended') return this.getDuration
      let ct = this.currentTime
      if (this.start) ct = ct - this.start
      return ct > 0 ? ct : 0
    },

    progress() {
      //
      if (!this.duration) return 0
      // if (this.playerState === 'ended') return 1
      return this.getCurrentTime / this.getDuration
    },

    previewTime() {
      if (!this.duration) return 0
      return this.getDuration * this.previewProgress
    },

    containerClass() {
      const list = []

      if (!this.clicked && this.playerState === 'playing')
        list.push('ml-player-timeline-transition-width')

      if (this.dark) list.push('m-player-timeline-dark')

      return list
    },
  },

  methods: {
    onMove({ offsetX }) {
      this.offsetX = offsetX
      this.previewProgress = (offsetX + 1) / this.$refs.timeline.clientWidth

      this.updateState()
    },
    updateState() {
      // sett if previewIs
      let diff =
        this.$refs.previewText.clientWidth -
        this.$refs.currentTimeText.clientWidth

      // const min = 0 - this.ctTextWidth

      this.overCurrentTime =
        diff < this.ctTextWidth && diff > 0 - this.ctTextWidth

      diff =
        this.$refs.durationText.clientWidth - this.$refs.previewText.clientWidth

      this.overDurText = diff < this.durTextWidth
    },
    updateCtOverDurText() {
      let diff =
        this.$refs.durationText.clientWidth -
        this.$refs.currentTimeText.clientWidth

      this.ctOverDurText = diff < this.durTextWidth
    },

    onClick() {
      this.clicked = true
      let n = this.previewTime
      if (this.start) n = n + this.start

      this.$emit('seekTo', n)

      setTimeout(() => {
        this.clicked = false
        this.updateState()
      }, 250)

      this.updateCtOverDurText()
      this.updateState()
    },
  },

  filters: {
    mt(n) {
      // remove flicker big time on YouTube
      if (n < 0) n = 0

      return mediaTime(n)
    },
  },
}
</script>
