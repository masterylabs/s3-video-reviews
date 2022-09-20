<template>
  <v-tooltip bottom :disabled="!tooltip">
    <template v-slot:activator="{ attrs, on }">
      <v-btn
        v-bind="attrs"
        v-on="on"
        :disabled="disabled"
        icon
        :color="value ? 'primary' : ''"
        @click="$emit('input', !value)"
      >
        <v-icon v-text="`mdi-${icon}`" />
      </v-btn>
    </template>
    <span v-if="tooltip" v-text="tooltip" />
  </v-tooltip>
</template>

<script>
  export default {
    props: {
      disabled: Boolean,
      value: Boolean,
      icon: {
        type: String,
        default: 'check',
      },
      tooltip: {
        type: String,
        default: null,
      },
    },
  }
</script>
