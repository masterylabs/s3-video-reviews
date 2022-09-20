<template>
  <v-tooltip
    bottom
    light
    small
    v-bind="{ disabled, openDelay }"
    color="grey lighten-4"
  >
    <template v-slot:activator="{ attrs, on }">
      <span v-bind="attrs" v-on="on">
        <slot />
      </span>
    </template>
    <span class="black--text">{{ value }}</span>
  </v-tooltip>
</template>
<script>
export default {
  props: {
    disabled: Boolean,
    value: {
      type: String,
      default: '',
    },
    openDelay: {
      type: [String, Number],
      default: 300,
    },
  },
}
</script>
