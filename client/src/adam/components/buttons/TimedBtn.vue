<template>
  <v-btn
    depressed
    v-bind="{ disabled }"
    :color="value ? 'timed' : ''"
    @click="$emit('input', !value)"
  >
    <v-icon class="mr-1">mdi-timer-outline</v-icon> Timed
  </v-btn>
</template>

<script>
export default {
  props: {
    value: Boolean,
    disabled: Boolean,
  },
}
</script>
