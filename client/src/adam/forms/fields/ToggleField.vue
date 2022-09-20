<template>
  <v-btn-toggle
    v-bind="{ value, multiple, rounded, color }"
    v-on="{ change }"
    borderless
    class="white"
    :active-class="inverse ? 'primary white--text' : ''"
    :background-color="inverse ? 'white' : 'grey lighten-5'"
  >
    <v-btn
      v-for="item in getItems"
      :key="item.value"
      :value="item.value"
      :icon="!!item.icon"
      height="36"
      color="white"
    >
      <v-icon
        v-if="item.icon"
        :color="item.iconColor"
        v-text="`mdi-${item.icon}`"
      />
      {{ item.text }}
    </v-btn>
  </v-btn-toggle>
</template>

<script>
export default {
  props: {
    inverse: Boolean,
    small: Boolean,
    multiple: Boolean,
    rounded: Boolean,
    color: {
      type: String,
      default: 'grey',
    },
    value: {
      type: [String, Number, Array],
      default: null,
    },
    items: {
      type: Array,
      required: true,
    },
    activeClass: {
      type: String,
      default: 'grey lighten-4', // 'primary white--text', // 'grey lighten-4',
    },
  },

  computed: {
    values() {
      if (this.multiple) {
        return this.value || []
      }
      if (this.value) {
        return [this.value]
      }

      return []
    },
    getItems() {
      return this.items.map((item) => {
        const active =
          this.values.length && this.values.indexOf(item.value) > -1
        return {
          ...item,
          iconColor: active ? 'primary' : 'grey darken-2',
        }
      })
    },
  },

  methods: {
    change(value) {
      this.$emit('input', value)
    },
  },
}
</script>
