<template>
  <v-tooltip bottom :disabled="!tooltip">
    <template v-slot:activator="{ attrs, on }">
      <v-btn v-bind="attrs" v-on="on" @click="click" text small height="36">
        <v-icon
          v-text="`mdi-${icon}`"
          :color="`toggle-${value ? 'on' : 'off'}`"
        />
      </v-btn>
    </template>
    <span v-text="tooltip" />
  </v-tooltip>
</template>

<script>
  export default {
    props: {
      value: Boolean,
      icon: {
        type: String,
        default: 'check',
      },
      tooltip: {
        type: String,
        default: '',
      },
    },

    methods: {
      click() {
        this.$emit('input', !this.value)
      },
    },
  }
</script>
