<template>
  <adam-toggle-text-field
    v-bind="{ value, items, label, disabled }"
    v-on="{ input }"
  />
</template>

<script>
  import items from '../../templates/variants'
  export default {
    props: {
      disabled: Boolean,
      label: {
        type: String,
        default: 'Justify',
      },
      value: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        items,
      }
    },

    methods: {
      input(v) {
        this.$emit('input', v)
      },
    },
  }
</script>
