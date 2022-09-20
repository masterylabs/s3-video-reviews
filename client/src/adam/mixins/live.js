import { findItems } from '../helpers/find'
import { jsonClense } from '../helpers/obj'
import { getCodeUrl } from '../helpers/dom'
export default {
  data() {
    return {
      videoTimes: {},
      vids: [],
    }
  },

  computed: {
    videoIds() {
      if (!this.body || !this.body.children) return []
      return findItems(this.body.children, 'video').map((video) => video.id)
    },

    items() {
      // return items
      if (!this.body || !this.body.children) return []
      return this.filterItems(jsonClense(this.body.children))
    },

    main() {
      return this.items.find(({ type }) => type === 'main')
    },

    footer() {
      return this.items.find(({ type }) => type === 'footer')
    },
  },

  methods: {
    message(e) {
      const subject = typeof e === 'string' ? e : e[0]
      const body = typeof e === 'string' ? null : e[1]

      if (subject === 'current-time') {
        this.onCurrentTime(body)
      }
      if (subject === 'checkout') {
        this.onCheckout()
      }

      if (subject === 'link') {
        this.onLink(body)
      }
    },

    onLink(e) {
      let url = e.checkout ? this.checkout_url : e.href

      if (!url) return

      if (url.indexOf('<') > -1) {
        url = getCodeUrl(url)
      }

      if (e.openNew) {
        window.open(url)
      } else if (window.top) {
        window.top.location.href = url
      } else {
        window.location.href = url
      }

      this.pauseVideos()
    },

    onCheckout() {
      this.pauseVideos()
      window.open(this.checkout_url)
    },

    pauseVideos() {
      window.QUICK_VIDEO_OFFERS_VIDEOS.forEach((player) => {
        player.pause()
      })
    },

    onCurrentTime({ id, ct }) {
      const item = this.vids.find((v) => v.id === id)

      if (!item) {
        return this.vids.push({ id, ct, progress: ct })
      }

      item.ct = ct
      if (ct > item.progress) item.progress = ct
    },

    canShow(e) {
      if (!e || !e.video || !e.showtime) return true

      const vid = this.vids.find(({ id }) => id === e.video)

      if (!vid) {
        // has not started, only show if video no longer exists
        return this.videoIds.indexOf(e.video) < 0
      }

      if (e.showlock && vid.progress >= e.showtime) {
        return true
      }

      return e.showtime <= vid.ct
    },

    filterItems(arr) {
      return arr
        .filter((item) => {
          if (item.opts.timed && !this.canShow(item.timed)) {
            return false
          }

          return !item.disabled
        })
        .map((item) => {
          if (item.children) {
            item.children = this.filterItems(item.children)
          }
          if (!item.id) {
            item.id = item.type
          }
          return item
        })
    },
  },

  beforeCreate() {
    window.QUICK_VIDEO_OFFERS_VIDEOS = []
  },
}
