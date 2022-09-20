<template>
  <adam-toggle-text-field v-bind="{ value, items, label }" v-on="{ input }" />
</template>

<script>
  export default {
    props: {
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
        items: [
          {
            text: 'Start',
            value: 'start',
          },
          {
            text: 'Center',
            value: 'center',
          },
          {
            text: 'Space Between',
            value: 'space-between',
          },
          {
            text: 'Space Around',
            value: 'space-around',
          },
          // {
          //   text: 'Space Evenly',
          //   value: 'space-evenly',
          // },
        ],
      }
    },

    methods: {
      input(v) {
        this.$emit('input', v)
      },
    },
  }
</script>
