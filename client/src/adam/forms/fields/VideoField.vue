<template>
  <div>
    <v-text-field
      v-bind="{ value, hideDetails, autofocus }"
      :label="m.lang.VIDEO_SRC"
      :loading="loading"
      outlined
      @input="$emit('input', $event)"
      @keyup="onKeyup"
    >
      <template v-slot:prepend-inner>
        <slot name="prepend-inner" />
      </template>

      <template v-slot:append>
        <v-chip
          v-if="duration"
          small
          text
          color="grey lighten-4"
          class="ml-2"
          >{{ duration | mt }}</v-chip
        >
        <v-chip
          v-if="service"
          small
          text
          color="grey lighten-4"
          class="ml-2 text-uppercase"
          >{{ service }}</v-chip
        >
        <v-btn icon small :disabled="!value" class="ml-2" @click="refresh">
          <v-icon v-text="`mdi-reload`" />
        </v-btn>
      </template>
    </v-text-field>

    <div
      style="
        position: fixed;
        left: -200px;
        top: 0;
        width: 200px;
        overflow: hidden;
      "
    >
      <m-player
        v-if="loading"
        :src="value"
        muted
        @ready="onReady"
        @invalid="onInvalid"
      />
    </div>
  </div>
</template>

<script>
import { getVideo } from '@/plugins/m-player/helpers/video'

import mediaTime from '@/_/helpers/media-time'

export default {
  props: {
    hideDetails: Boolean,
    autofocus: Boolean,
    value: {
      type: String,
      default: '',
    },
    duration: {
      type: Number,
      default: undefined,
    },
  },
  data() {
    return {
      loading: false,
      wait: null,
    }
  },

  computed: {
    service() {
      if (!this.value) return ''

      const video = getVideo(this.value)

      return video && video.service ? video.service : ''
    },
  },

  methods: {
    onKeyup() {
      if (this.loading) {
        this.setLoading(false)
        clearTimeout(this.wait)
        this.wait = setTimeout(() => {
          this.onKeyup()
        }, 50)
        return
      }

      // check to see it is valid
      if (this.service) {
        this.$emit('service', this.service)
        this.loadPlayer()
      }
    },

    onReady(n) {
      this.$emit('duration', n)
      this.setLoading(false)
    },

    onInvalid() {
      this.setLoading(false)
    },

    refresh() {
      if (this.loading) {
        return this.setLoading(false)
      }

      this.loadPlayer()
    },
    loadPlayer() {
      this.setLoading(true)
    },

    setLoading(value) {
      this.loading = value
      this.$emit('loading', value)
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
