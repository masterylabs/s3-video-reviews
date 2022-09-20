<template>
  <ml-login-form
    :endpoint="`license${!update ? '?activate=1' : ''}`"
    @success="onSuccess"
  >
    <slot>{{ m.lang.ACTIVATE_LICENSE_BTN }}</slot>
  </ml-login-form>
</template>

<script>
export default {
  props: {
    update: Boolean,
  },
  methods: {
    onSuccess({ data }) {
      // welcome screen
      this.$store.commit('ml/SET_DATA_PROP', { license: data })
    },
  },
}
</script>
