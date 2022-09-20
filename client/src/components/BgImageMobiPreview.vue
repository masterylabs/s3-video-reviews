<template>
  <v-expand-transition>
    <div
      v-show="
        layout.bgImage && layout.bgImage.previewMobi && layout.bgImage.mobiSrc
      "
      class="m-mobi-bg-preview rounded-xl elevation-12"
      :class="layout.bgImage.mobiLandscape ? 'm-mobi-bg-preview-landscape' : ''"
    >
      <v-img
        :src="layout.bgImage.mobiSrc"
        :style="`filter:${layout.bgImage.filter};opacity:1`"
        height="100%"
        width="100%"
      ></v-img>

      <v-btn
        absolute
        right
        top
        fab
        color="error"
        class="mt-11"
        @click="closeMobilePreview"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>
  </v-expand-transition>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
export default {
  computed: {
    ...mapState({
      layout: 'layout',
    }),
    ...mapGetters({
      bgImage: 'layout/bgImage',
      bgPreview: 'adam/bgPreview',
    }),
  },

  methods: {
    closeMobilePreview() {
      this.bgImage.previewMobi = false
    },
  },
}
</script>

<style scoped lang="scss">
.m-mobi-bg-preview {
  position: fixed;
  left: 50%;
  top: 90px;
  background: white;
  width: 412px;
  height: 732px;
  margin-left: -206px;
  z-index: 1000;
  opacity: 1;
  overflow: hidden;
  border: solid 3px rgba(255, 255, 255, 0.735);
  transition: all 600ms;
  transition-timing-function: cubic-bezier(0.6, -0.28, 0.735, 0.045);

  &.m-mobi-bg-preview-landscape {
    height: 412px !important;
    width: 732px !important;
    margin-left: -366px !important;
    margin-top: 25px;
    transition: all 600ms;
    transition-timing-function: cubic-bezier(0.6, -0.28, 0.735, 0.045);
  }
}
</style>
