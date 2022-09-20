// import copy from 'copy-text-to-clipboard'

export default {
  methods: {
    copyToClipboard(str) {
      this.$copyText(str).then(() => {
        this.$app.success('Copied to clipboard!')
      })
    },
  },
}
