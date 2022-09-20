<template>
  <div>
    <v-row dense>
      <v-col v-for="icon in icons" :key="icon" cols="2" class="text-center">
        <v-icon
          size="28"
          :color="value === icon ? 'primary' : ''"
          @click="select(icon)"
        >
          mdi-{{ icon }}
        </v-icon>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
    defaultValue: {
      type: String,
      default: 'bucket',
    },
  },

  data() {
    return {
      icons: [
        'bucket',
        'folder',
        'folder-image',
        'folder-play',
        'folder-star',
        'folder-zip',
        'folder-home',
        'folder-account',
        'video',
        'youtube',
        'music-box',
        'volume-high',

        'cloud',
        'checkbox-blank-circle',
        'square',
        'triangle',
        'hexagon',
        'star',
        'shape',
        'shark',
        // 'aws',
        'cog',
        'lock',
        'storefront',
        'home',
      ],
    }
  },
  methods: {
    select(icon) {
      if (icon === this.value) {
        icon = ''
      }
      this.$emit('input', icon)
    },
  },
}
</script>
