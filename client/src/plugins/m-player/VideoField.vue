<template>
  <div :class="hideDetails ? '' : 'mb-6'">
    <v-row>
      <v-col>
        <v-text-field
          color="primary"
          :value="value"
          :autofocus="autofocus && !value"
          :label="label"
          hide-details
          :loading="load"
          @input="onInput"
        >
        </v-text-field>
      </v-col>
      <v-col v-if="isAppend">
        <slot name="append" />
      </v-col>
    </v-row>

    <div style="display: none">
      <m-player
        v-if="load"
        v-bind="playerAttrs"
        muted
        @ready="onPlayerReady"
        @service="onService"
      >
      </m-player>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    autofocus: Boolean,
    hideDetails: Boolean,

    value: {
      type: String,
      default: '',
    },
    previewAttrs: {
      type: Object,
      default() {
        return {}
      },
    },
    color: {
      type: String,
      default: '',
    },
    seekTo: {
      type: Number,
      default: null,
    },
    label: {
      type: String,
      default: 'Video ID or URL',
    },
  },

  data() {
    return {
      load: false,
      show: false,
      playerClosed: false,
      remotePause: false,
    }
  },

  computed: {
    playerAttrs() {
      return {
        ...this.previewAttrs,
        noControls: false,
        src: this.value,
        remotePause: this.remotePause,
        remoteSeek: this.seekTo,
        lockControls: true,
        color: this.color,
        emitService: true,
      }
    },
    isAppend() {
      return !!this.$slots.append
    },
  },

  methods: {
    onService(v) {
      this.$emit('service', v)
    },
    onInput(v) {
      this.$emit('input', v)
      if (v) this.load = true
    },
    onPlayerReady(n) {
      this.$emit('duration', n)
      this.load = false
    },
    onToggleVideo() {
      if (!this.load) {
        return (this.load = true)
      }
      this.playerClosed = !this.playerClosed
      this.remotePause = !this.remotePause
    },

    closePlayer() {
      this.playerClosed = true
      this.remotePause = !this.remotePause
    },
  },
}
</script>
