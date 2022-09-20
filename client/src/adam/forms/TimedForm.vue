<template>
  <v-row align="center" class="my-0">
    <v-col cols="3">
      <!-- item.timed.video: {{ item.timed.video }} -->
      <adam-video-select
        v-model="item.timed.video"
        :items="videoItems"
        hide-details
      />
    </v-col>
    <v-col>
      <m-player-time-field
        v-model="item.timed.showtime"
        label="Show Time"
        :max="duration || 2700"
        hide-details
      />
    </v-col>

    <v-col class="shrink mt-n1 ml-n2x">
      <adam-lock-toggle
        v-model="item.timed.showlock"
        color="toggle-on"
        tooltip="Keep showing once shown"
      />
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters } from 'vuex'
import formMixin from '../mixins/form'
import { findItems } from '../helpers/find'
export default {
  mixins: [formMixin],
  computed: {
    ...mapGetters({
      videos: 'adam/videos',
    }),
    duration() {
      if (!this.item.timed || !this.item.timed.video || !this.videos.length) {
        return 0
      }

      const video = this.videos.find((v) => v.id === this.item.timed.video)

      return video && video.duration ? video.duration : 0
    },

    // childVideos() {
    //   return findItems(this.item.children, 'video').map((v) => v.id)
    // },

    videoItems() {
      const without = findItems(this.item.children, 'video').map((v) => v.id)
      const items = [...this.$store.getters['adam/videoItems']]
      return items.filter(
        (v) => v.value !== this.videoId && without.indexOf(v.value) < 0
      )
    },
  },
  created() {
    if (!this.item.timed) {
      this.item.timed = {
        video: '',
        showtime: 0,
        showlock: false,
      }
    }
  },
}
</script>
