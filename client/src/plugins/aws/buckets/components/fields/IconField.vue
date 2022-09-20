<template>
  <div>
    <v-row v-for="(items, i) in rows" :key="i" no-gutters justify="center">
      <v-btn
        v-for="item in items"
        :key="item"
        icon
        small
        class="mx-1"
        @click="$emit('input', item)"
      >
        <v-icon
          v-text="`mdi-${item}`"
          :color="getValue !== item ? '' : 'primary'"
        ></v-icon>
      </v-btn>
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
      rows: [
        [
          'bucket',
          'folder',
          'file-multiple',
          // 'bucket-outline',
          // 'image',
          'folder-image',
          'video',
          'youtube',
          'music-box',
          'volume-high',
          //   'folder-zip-outline',
        ],
        [
          //   'file-cloud',
          'lock',
          'storefront',
          'file-star',
          'star',
          'checkbox-blank-circle',
          'square',
          'triangle',
          'hexagon',
        ],
      ],
    }
  },

  computed: {
    getValue() {
      return this.value || this.defaultValue
    },
  },
}
</script>
