<template>
  <v-btn icon :color="value ? 'primary' : ''" @click="click">
    <v-icon> mdi-{{ icon }}-{{ value ? 'up' : 'down' }} </v-icon>
  </v-btn>
</template>

<script>
  export default {
    props: {
      value: Boolean,
      icon: {
        type: String,
        default: 'chevron',
      },
    },
    methods: {
      click() {
        this.$emit('input', !this.value)
      },
    },
  }
</script>
