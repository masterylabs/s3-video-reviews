<template>
  <v-app
    style="background-color: none"
    :class="`space-y-${theme.spaceY} box-space-y-${theme.boxSpaceY}`"
  >
    <!-- Loading View  -->
    <!-- ready: {{ ready }} -->
    <v-main v-if="!ready">
      <v-container fill-height>
        <v-row align="center" justify="center">
          <v-progress-circular indeterminate size="100" />
        </v-row>
      </v-container>
    </v-main>
    <!-- Live View  -->

    <!-- Main  -->
    <adam-item
      v-if="ready && main"
      v-bind="main"
      v-on="{ message }"
      :theme="theme"
    />

    <!-- Footer  -->
    <adam-item
      v-if="ready && footer"
      v-bind="footer"
      v-on="{ message }"
      :theme="theme"
    />

    <adam-cookies-notice-item v-if="cookies_notice" v-bind="cookies_notice" />
  </v-app>
</template>

<script>
import liveMixin from './mixins/live'
import { getJson } from '@/plugins/helpers'
const getBgScale = (bg) => {
  if (!bg || !bg.filter || bg.filter.indexOf('blur(') < 0) {
    return 1
  }

  const i = bg.filter.split('blur(')
  const b = i[1].split('p')
  const n = parseInt(b[0])

  if (!n) {
    return 1
  }

  if (n > 15) {
    return 1.2
  }

  if (n > 9) {
    return 1.1
  }

  if (n > 4) {
    return 1.05
  }

  return 1.01
}

export default {
  mixins: [liveMixin],
  data() {
    return {
      ready: false,
      drawer: false,
      body: {},
      theme: {},
      checkout_url: '',
      cookies_notice: null,
    }
  },

  methods: {
    onNotFound() {
      window.location.href = window.location.origin
    },
    loadPage(data) {
      for (const k in data.data) {
        this[k] = data.data[k]
        //
      }
      this.data = data.data

      if (data.cookies_notice) {
        this.cookies_notice = data.cookies_notice
      }

      this.$vuetify.theme.isDark = !!data.data.theme.dark

      this.ready = true
    },

    loadPreviewBg(bg) {
      let bgImage = document.querySelector('.bg-image')

      if (!bgImage) {
        bgImage = document.createElement('div')
        bgImage.className = 'bg-image'
        document.body.prepend(bgImage)
      }

      if (bg.src) {
        bgImage.style['background-image'] = `url(${bg.src})`
        bgImage.style.filter = bg.filter ? bg.filter : ''
        // TODO: scale
        const scale = getBgScale(bg)

        if (scale && scale !== 1) {
          bgImage.style.transform = `scale(${scale})`
        }
      } else {
        bgImage.style['background-image'] = ''
      }
    },

    loadPreviewBgColor(data) {
      const bgColor = data.bg.color
        ? data.bg.color
        : data.theme.dark
        ? '#121212'
        : ''
      document.body.style.backgroundColor = bgColor
    },

    loadPreview() {
      // listen
      window.addEventListener(
        'message',
        (event) => {
          const data = getJson(event.data)

          if (!data || !data.previewContent) {
            return
          }

          const contents = data.previewContent

          this.loadPage(contents)
          this.loadPreviewBgColor(contents.data)

          this.loadPreviewBg(contents.data.bg)
        },
        false
      )

      window.onbeforeunload = function () {
        window.opener.postMessage('preview_closed', '*')
        self.close()
      }

      window.opener.postMessage('preview_listening', '*')
    },
  },

  beforeMount() {
    const data = window._DATA

    if (typeof data === 'string') {
      return this.onNotFound()
    }

    if (data.is_preview) {
      // return
      return this.loadPreview()
    }

    this.loadPage(data)
  },
}
</script>

<style lang="scss">
@import '../styles/_spacing.scss';
.overflow-hidden {
  overflow: hidden;
}
</style>
