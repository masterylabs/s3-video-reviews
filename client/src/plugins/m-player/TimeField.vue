<template>
  <div>
    <v-row align="center" no-gutters class="pb-5x">
      <div v-text="label" class="mr-3 v-label grey--text text--darken-2" />
      <v-slider
        v-model="slider"
        :max="getMax"
        hide-details
        color="primary"
        thumb-color="primary"
        track-color="grey"
        @click="onClick"
      >
      </v-slider>
      <v-btn
        color="primary"
        class="ml-3"
        :disabled="atMin"
        icon
        @click="slider--"
        @mousedown="onPress(-1)"
        @mouseup="mouseup"
      >
        <v-icon>mdi-minus</v-icon>
      </v-btn>
      <v-btn
        color="primary"
        :disabled="atMax"
        icon
        @click="slider++"
        @mousedown="onPress(1)"
        @mouseup="mouseup"
        ><v-icon>mdi-plus</v-icon>
      </v-btn>

      <v-btn
        @click="onClick"
        warning
        outlined
        rounded
        small
        color="primary"
        class="ml-3 body-2"
        style="width: 76px"
      >
        {{ slider | mt }}
      </v-btn>
    </v-row>
  </div>
</template>

<script>
import mediaTime from '@/_/helpers/media-time'
export default {
  props: {
    value: {
      type: Number,
      default: 0,
    },
    max: {
      type: Number,
      default: 0,
    },
    label: {
      type: String,
      default: 'Time',
    },
  },

  data() {
    return {
      slider: -1,
      watcherReady: false,
      wait: null,
      waitInt: null,
      slideWait: null,
      speedWait: null,
      mouseDown: false,
    }
  },

  watch: {
    slider() {
      if (!this.watcherReady) return (this.watcherReady = true)
      clearTimeout(this.slideWait)

      this.slideWait = setTimeout(() => {
        this.$emit('input', this.slider)
      }, 50)
    },
  },

  created() {
    // fire watcher on all
    this.slider = this.value ? Math.floor(this.value) : 0
  },

  computed: {
    getMax() {
      return this.max ? Math.floor(this.max) : 0
    },
    atMin() {
      return !this.value ? true : false
    },
    atMax() {
      return this.getVal === this.getMax
    },
  },

  methods: {
    onClick() {
      clearTimeout(this.slideWait)
      this.$emit('input', this.slider)

      this.$emit('click')
    },

    onPress(v = 1) {
      this.mouseDown = true
      const value = () => (this.slider = this.slider + v)
      this.wait = setTimeout(() => {
        let speed = 125
        this.waitInt = setInterval(value, speed)
        this.speedWait = setInterval(() => {
          speed = Math.floor(speed * 0.4)
          clearInterval(this.waitInt)
          this.waitInt = setInterval(value, speed)
        }, 3000)
      }, 500)
    },

    mouseup() {
      if (this.mouseDown) {
        this.mouseDown = false
        this.$emit('input', this.slider)
        clearTimeout(this.wait)
        clearTimeout(this.waitInt)
        clearInterval(this.speedWait)
        clearTimeout(this.slideWait)
      }
    },
  },

  filters: {
    mt(n) {
      return mediaTime(n)
    },
  },
}
</script>
