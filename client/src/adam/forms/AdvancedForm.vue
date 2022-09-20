<template>
  <div>
    <m-code-field v-model="headerCode" label="Header Code, Scripts" />
    <m-code-field v-model="footerCode" label="Footer Code, Scripts" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      rebuildingBucket: false,
    }
  },
  computed: {
    headerCode: {
      get() {
        return this.$store.getters['adam/page'].header_code || ''
      },
      set(header_code) {
        this.$store.commit('adam/SET_PAGE_PROP', { header_code })
      },
    },
    footerCode: {
      get() {
        return this.$store.getters['adam/page'].footer_code
      },
      set(footer_code) {
        this.$store.commit('adam/SET_PAGE_PROP', { footer_code })
      },
    },
  },
}
</script>
