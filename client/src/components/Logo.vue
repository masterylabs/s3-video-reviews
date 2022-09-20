<template>
  <div :style="`opacity:${opacity}`" style="position: relative">
    <a v-if="app.logo" :href="app.logo" class="mr-1" @click.prevent="click">
      <img :src="app.logo" :style="`max-height: ${size}px`" />
    </a>

    <template v-else>
      <v-icon class="mr-1" color="accent" v-bind="{ size }"
        >mdi-bucket-outline</v-icon
      >
      <v-icon
        size="16"
        class="mr-3"
        style="position: absolute; left: 14px; top: 15px"
        color="accent"
        >mdi-tag</v-icon
      >
    </template>
  </div>
</template>

<script>
export default {
  props: {
    size: {
      type: [Number, String],
      default: 44,
    },
    color: {
      type: String,
      default: '',
    },
    opacity: {
      type: [Number, String],
      default: 1,
    },
  },
  computed: {
    app() {
      return this.$store.getters.app
    },
  },

  methods: {
    click() {
      if (this.app.logo_link) {
        return window.open(this.app.logo_link)
      }

      if (this.$route.path !== '/') {
        this.$router.push({ path: '/' })
      }
    },
  },
}
</script>
