<template>
  <v-snackbar v-model="snackbar" :timeout="-1">
    {{ text }}

    <template v-slot:action="{ attrs }">
      <v-btn color="white" outlined v-bind="attrs" @click="onAgree">
        {{ btn_text || 'OK!' }}
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      required: true,
    },
    btn_text: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      snackbar: false,
      key: '',
    }
  },

  methods: {
    onAgree() {
      const now = Math.floor(Date.now() / 1000)
      localStorage.setItem(this.key, now)
      this.snackbar = false
    },
  },

  mounted() {
    const now = Math.floor(Date.now() / 1000)
    const expire = now - 86400

    this.key = 'mlqvo1121_cookies_notice'

    let value = localStorage.getItem(this.key)

    if (!value || parseInt(value) < expire) {
      this.snackbar = true
    }
  },
}
</script>
