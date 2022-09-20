<template>
  <div>
    <div
      ref="container"
      class="m-player-container"
      v-bind="containerAttrs"
      v-on="onContainer"
    >
      <div
        class="m-player grey darken-4"
        ref="player"
        :style="maxHeight ? `max-height:${maxHeight}px` : ''"
      ></div>

      <img
        v-if="showPoster"
        style="position: absolute; left: 0; top: 0; width: 100%; height: 100%"
        :src="poster"
        alt="Video Poster"
      />

      <m-player-click-mask v-if="useClickMask" v-on="onClickMask" />

      <div v-if="!overlayFullTop && overlayFull" class="m-player-overlay-full">
        <slot name="overlay-full" v-bind="{ playerHeight, playerWidth }" />
      </div>

      <m-player-layer v-if="!noControls" align="end" :max-height="maxHeight">
        <v-expand-transition>
          <m-player-controls
            v-show="showControls"
            v-bind="controlsAttr"
            v-on="onControls"
          >
            <template v-if="showPlayPause" v-slot:start>
              <m-player-play-pause-btn
                v-bind="playPauseAttrs"
                v-on="onPlayPause"
              />
            </template>

            <template v-slot:center>
              <m-player-timeline v-bind="timelineAttrs" v-on="onTimeline" />
            </template>

            <template v-if="showVolume" v-slot:end>
              <m-player-volume-btn v-bind="volumeAttrs" v-on="onVolume" />
            </template>
          </m-player-controls>
        </v-expand-transition>
      </m-player-layer>

      <m-player-center-play-btn
        v-if="showCenterPlay"
        v-bind="centerPlayAttrs"
        v-on="onCenterPlay"
      />

      <m-player-layer v-if="activeSlot['top-right']" top right>
        <slot name="top-right" />
      </m-player-layer>

      <v-fade-transition>
        <m-player-center-loading
          v-if="showCenterLoading"
          v-bind="centerLoadingAttrs"
        />
      </v-fade-transition>

      <m-player-muted-notice-btn
        v-if="showMutedNoticeBtn"
        v-bind="mutedNoticeBtnAttrs"
        v-on="onMutedNoticeBtn"
      />

      <m-player-preview-mask
        v-if="isPreview"
        v-bind="previewAttrs"
        v-on="onPreview"
      />

      <slot />

      <m-player-layer v-if="showOverlayCenter">
        <div>
          <slot name="overlay-center" v-bind="{ playerHeight, playerWidth }" />
        </div>
        <slot />
      </m-player-layer>

      <div v-if="overlayFullTop && overlayFull" class="m-player-overlay-full">
        <slot name="overlay-full" v-bind="{ playerHeight, playerWidth }" />
      </div>
    </div>

    <!-- <dev-raw :value="" /> -->
    <m-player-footer v-if="showFooter" v-bind="footer" />
  </div>
</template>

<script>
import player from './player.js'
export default player
</script>
