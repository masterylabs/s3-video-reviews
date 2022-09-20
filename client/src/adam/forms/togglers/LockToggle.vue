<template>
  <v-tooltip bottom :disabled="!tooltip">
    <template v-slot:activator="{ attrs, on }">
      <v-btn icon v-bind="attrs" v-on="on">
        <v-icon
          v-text="`mdi-lock${value ? '' : '-open-outline'}`"
          :color="value ? color : ''"
          @click="$emit('input', !value)"
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
      color: {
        type: String,
        default: 'error',
      },
      tooltip: {
        type: String,
        default: '',
      },
    },
  }
</script>
