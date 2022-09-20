<template>
  <div>
    <m-player
      v-bind="video"
      :remote-play="remotePlay"
      :remote-pause="remotePause"
      @ended="onEnded"
    />
    <v-btn @click="remotePlay = !remotePlay">REMOTE PLAY</v-btn>
    <v-btn @click="remotePause = !remotePause">REMOTE PAUSE</v-btn>
    a
  </div>
</template>

<script>
  export default {
    data() {
      return {
        remotePlay: false,
        remotePause: false,
        playsinline: true,

        video: {
          nativeControls: false,
          noAudioBtn: true,
          // noCurrentTime: true,
          // noDuration: true,

          // muted: true,
          // autoplay: true,
          // loop: true,
          noControls: false,
          // lockControls: true,
          noPause: false,
          // src: 'plJe0uDszaY', // 'F4j3cVgVHTo', // '2dcFCoi7JLA',
          // src: '1O0yazhqaxs', // 3 second
          // src: 'http://media.test/video.mp4',
          // src: 'https://www.youtube.com/watch?v=IiBp4cvgxc4',
          // src: 'https://studio.youtube.com/video/12p-Lr0zg-o/edit?o=U',
          // src: 'https://vimeo.com/manage/videos/593482330', // yes

          // short offer (Video Streamer)
          // src: 'https://wpvideostreamer.com/wp-video-streamer/i/vi783016683ba6f',

          // src: 'https://vimeo.com/128225642',
          // src: 'https://player.vimeo.com/video/593482330', // yes
          // src: '593482330', yes
          // src:'http://wp-video-streamer.test/wp-video-streamer/i/vic4190e2f5e3a1',

          // src: 'lvk3w9s01y', // wistia
          color: '#ff0000',
          // dark: false,
          // start: 4,
          // useStart: false,
          // end: 5,
          // useEnd: true,
          // preview: true, //true,
          // previewStart: 3,
          // usePreviewStart: true,
          // previewEnd: 6,
          // usePreviewEnd: true,
          // debug: true,
          // title: 'Marketing Veteran Jeff Champagne Speaks About Video Payflow',
          // color: '#111111',
        },
      }
    },

    methods: {
      onEnded() {
        //
      },

      pauseVideo() {
        this.video.pause = !this.video.pause
      },
      playVideo() {
        this.video.play++
      },
    },
  }
</script>
