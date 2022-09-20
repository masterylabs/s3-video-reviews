import config from './config'

export default function() {
  return {
    config,
    player: null,
    video: {
      src: '',
      service: '',
    },
    isMuted: false,
    isAutoplay: false,
    // isPreview: false,
    over: false,
    playerReady: false,
    currentTime: 0,
    duration: 0,
    playerState: 'unstarted',
    defaultColor: config.defaultColor,
    defaultBtn: {
      flat: true,
    },
    options: {
      start: 0,
      end: 0,
    },
    lastEmittedCurrentTime: -1,

    onEvents: {
      'toggle-play': [],
    },
    service: null,
  }
}
