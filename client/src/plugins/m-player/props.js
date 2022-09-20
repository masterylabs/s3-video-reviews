import { nanoid } from 'nanoid'

export default {
  id: {
    type: String,
    default() {
      return 'm-player_' + nanoid()
    },
  },
  rounded: {
    type: String,
    default: '',
  },
  dark: {
    type: Boolean,
    default: null,
  },
  noPause: Boolean,
  noAudioBtn: Boolean,
  noCenterPlay: Boolean,
  nativeControls: Boolean, // nativeControls
  emitCurrentTime: Boolean,
  emitService: Boolean,
  emitPlay: Boolean,
  playsinline: {
    type: Boolean,
    default: true,
  },
  muted: Boolean,

  // remote controls
  remotePlay: Boolean,
  remotePause: Boolean,
  remoteTogglePlay: Boolean,
  remoteMute: Boolean,
  remoteLoading: Boolean,
  remoteSeek: {
    type: Number,
    default: null,
  },
  remoteSeekToAndPlay: {
    type: Number,
    default: null,
  },

  // debug: Boolean,
  noControls: Boolean,
  lockControls: Boolean,
  noReplay: Boolean,
  // noPause: Boolean,
  autoplay: Boolean,
  loop: Boolean,
  // title: {
  //   type: [String, Object],
  //   default: '',
  // },
  src: {
    type: [String, Array],
    default: '',
  },
  poster: {
    type: String,
    default: '',
  },
  endPoster: {
    type: String,
    default: '',
  },

  // togglePlay: {
  //   type: [Boolean, Number],
  //   default: null,
  // },
  // captionsSize: {
  //   type: Number,
  //   defualt: 0,
  // },

  color: {
    type: String,
    default: '',
  },
  controlsHeight: {
    type: [String, Number],
    default: 55,
  },
  start: {
    type: [Number, String],
    default: 0,
  },
  end: {
    type: [Number, String],
    default: 0,
  },
  useStart: {
    type: Boolean,
    default: null,
  },
  useEnd: {
    type: Boolean,
    default: null,
  },

  maxHeight: {
    type: [Number, String],
    default: null,
  },

  //
}
