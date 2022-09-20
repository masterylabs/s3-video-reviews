<template>
  <v-card v-bind="{ width }">
    <v-card-title>Cross-origin resource sharing (CORS)</v-card-title>
    <v-card-text>
      <aws-buckets-cors-snippet />
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    width: {
      type: [String, Number],
      default: 500,
    },
  },
}
</script>
