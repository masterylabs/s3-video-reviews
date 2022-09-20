<template>
  <v-card v-bind="{ color }" class="my-5" flat>
    <v-card-title
      v-if="title"
      v-text="title"
      class="text-body-1 font-weight-regular"
    />
    <v-card-text>
      <pre><slot /></pre>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: 'grey-lighten-4',
    },
  },
}
</script>
<style scoped>
pre {
  text-align: start;
  overflow: auto;
}
</style>
