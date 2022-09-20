<template>
  <div>
    <!-- colors: {{ colors }} -->

    <v-card v-for="color in colors" :key="color.value" class="mb-5">
      <v-card-title
        v-if="color.title"
        class="body-1 py-2 grey darken-3 white--text"
        >{{ color.title }}</v-card-title
      >
      <v-color-picker
        v-model="settings[color.value]"
        dot-size="25"
        swatches-max-height="200"
        mode="hexa"
        @input="onColor(color.value, $event)"
      />
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import colorMixin from '../mixins/color'

export default {
  mixins: [colorMixin],

  computed: {
    ...mapGetters({
      settings: 'brand/settings',
      colors: 'brand/colorFields',
    }),
  },

  methods: {
    onColor(key, value) {
      if (this.settings.is_active && this.colorMap[key]) {
        this.setColor(this.colorMap[key], value)
      }
    },
  },

  created() {
    if (this.colors.length) {
      // setup default values
      this.colors.forEach((color) => {
        if (color.default_value && !this.settings[color.value]) {
          // this.settings[color.value] = color.default_value
        }
      })
    }
  },

  mounted() {},
}
</script>
