<template>
  <v-select
    color="primary"
    v-bind="{ items, label, value, hideDetails }"
    outlined
    @change="onChange"
  ></v-select>
</template>

<script>
export default {
  props: {
    hideDetails: Boolean,
    label: {
      type: String,
      default: 'Video',
    },
    value: {
      type: String,
      default: '',
    },
    videoId: {
      type: String,
      default: '',
    },
    items: {
      type: Array,
      default() {
        return []
      },
    },
  },

  methods: {
    onChange(value) {
      this.$emit('input', value)
    },
  },
}
</script>
