<template>
  <v-btn-toggle
    v-bind="{ value, multiple }"
    v-on="{ change }"
    :style="textfield ? `margin-top:-2px` : ''"
    borderless
  >
    <v-btn
      v-for="item in getItems"
      :key="item.value"
      :value="item.value"
      :iconx="!!item.icon"
      height="28"
      :color="item.color"
      :class="textfield ? 'rounded' : 'rounded-tr rounded-tl'"
    >
      <v-icon
        v-if="item.icon"
        :color="item.iconColor"
        v-text="`mdi-${item.icon}`"
        size="19"
      />
      <span
        v-if="item.text"
        v-text="item.text"
        :class="item.active ? 'white--text' : ''"
      />
    </v-btn>
  </v-btn-toggle>
</template>

<script>
// https://vuetifyjs.com/en/api/v-btn-toggle/#props
export default {
  props: {
    focused: Boolean,
    multiple: Boolean,
    textfield: Boolean,
    value: {
      type: [String, Number, Array],
      default: null,
    },
    items: {
      type: Array,
      required: true,
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
        const active = this.values.indexOf(item.value) > -1
        return {
          active,
          ...item,
          color:
            active && this.focused
              ? 'primary'
              : active
              ? 'grey lighten-1'
              : 'white',
          iconColor: active ? 'white' : 'grey darken-2',
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
