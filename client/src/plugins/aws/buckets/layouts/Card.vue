<template>
  <v-card v-bind="{ width }">
    <slot name="top" />
    <!-- <v-system-bar window dark color="secondary">
      <span class="primary--text ml-3">{{ title }}</span>
      <v-spacer></v-spacer>
      <v-icon @click="$emit('close')">mdi-close</v-icon>
    </v-system-bar> -->
    <v-card-text>
      <slot />
    </v-card-text>

    <v-card-actions class="mt-n3">
      <slot name="actions" />
    </v-card-actions>

    <slot name="append" />
  </v-card>
</template>

<script>
export default {
  props: {
    closable: Boolean,
    title: {
      type: String,
      default: '',
    },
    width: {
      type: [String, Number],
      default: '',
    },
  },
}
</script>
