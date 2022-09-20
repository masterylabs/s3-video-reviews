<template>
  <v-card class="editor-container">
    <v-system-bar v-if="!noBar" dark color="secondary">
      <span v-if="!noTitle">{{ title }}</span>
      <v-spacer />

      <template v-if="ready">
        <span>Lines: {{ totalLines }}</span>
        <span class="ml-2"
          >Size:
          <span class="font-weight-medium">{{
            value.length | bytes
          }}</span></span
        >
      </template>
      <v-icon v-if="closable" @click="$emit('close')" class="ml-2" size="20">
        mdi-close
      </v-icon>
    </v-system-bar>

    <div ref="editor" />

    <m-loading-circle v-if="!isReady || loading" />

    <!-- <v-progress-circular
      v-if="!isReady || loading"
      class="editor-loading"
      indeterminate
      size="90"
      color="grey lighten-2"
    /> -->
  </v-card>
</template>

<script>
import { WindowFrame } from '@/plugins/window-frame'
import prettyBytes from 'pretty-bytes'

export default {
  props: {
    fullscreen: Boolean,
    ready: {
      type: Boolean,
      default: true,
    },
    closable: Boolean,
    noTitle: Boolean,
    noBar: Boolean,
    loading: Boolean,

    // code editor
    lineNumbers: Boolean,
    readonly: Boolean,
    contentType: {
      type: String,
      default: '',
    },
    language: {
      type: String,
      default: '',
    },

    value: {
      type: String,
      default: '',
    },
    title: {
      type: String,
      default: 'Code Editor',
    },
    // height: {
    //   type: [String, Number],
    //   default: 500,
    // },
  },

  data() {
    return {
      isReady: false,
      iframe: null,
      editor: null,
      target: null,
      targetLoaded: false,
      contentTypes: {
        'text/html': 'html',
        'application/javascript': 'js',
      },
      editorScript:
        'https://cdn.jsdelivr.net/npm/codeflask@1.4.1/build/codeflask.min.js',
    }
  },

  computed: {
    totalLines() {
      return this.value.split(/\r?\n/).length
    },
  },

  methods: {
    onUpdate(value) {
      this.$emit('input', value)
    },

    updateCode(value) {
      this.editor.updateCode(value)
    },

    loadEditor() {
      this.editor = new this.target.w.CodeFlask('#editor', {
        language: this.getLanguage(),
        lineNumbers: this.lineNumbers,
        readonly: this.readonly,
      })

      this.editor.onUpdate(this.onUpdate)
      this.updateCode(this.value)
      this.isReady = true
    },

    getLanguage() {
      if (this.language) {
        return this.language
      }

      if (this.contentType && this.contentTypes[this.contentType]) {
        return this.contentTypes[this.contentType]
      }
      return ''
    },
  },

  mounted() {
    // register window event
    this.target = new WindowFrame(this.$refs.editor)

    this.target.width = '100%'
    this.target.height = 500

    this.target.on('script-loaded', () => {
      this.target.createDiv('editor')

      if (this.ready) {
        this.loadEditor()
      } else {
        this.$watch('ready', () => {
          this.loadEditor()
        })
      }
    })

    this.target.addScript(this.editorScript)

    this.target.mount()
  },

  filters: {
    bytes(n) {
      return prettyBytes(n)
    },
  },
}
</script>
<style scoped>
.editor-container {
  position: relative;
}
/* .editor-loading {
  position: absolute;
  left: 50%;
  top: 50%;
  margin-top: -45px;
  margin-left: -45px;
} */
</style>
