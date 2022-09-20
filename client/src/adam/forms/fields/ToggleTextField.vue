<template>
  <v-btn-toggle
    v-bind="{ value, multiple, rounded, color }"
    v-on="{ change }"
    borderless
    active-class="white primary--text"
    background-color="grey lighten-5"
    class="mb-4"
    dense
  >
    <v-btn
      v-for="item in getItems"
      :key="item.value"
      :value="item.value"
      :icon="!!item.icon"
      v-bind="{ disabled }"
      height="36"
      text
    >
      <span class="font-weight-regular">
        {{ item.text }}
      </span>
    </v-btn>
  </v-btn-toggle>
</template>

<script>
  export default {
    props: {
      disabled: Boolean,
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
          const active = this.values.indexOf(item.value) > -1
          return {
            active,
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
