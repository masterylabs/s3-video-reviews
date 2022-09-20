<template>
  <div>
    <div v-if="title" class="title">{{ title }}</div>
    <pre>{{ valueString }}</pre>
  </div>
</template>
<script>
const props = {
  name: 'm-raw-displayer',
  title: {
    type: String,
    required: false,
  },
  value: {
    required: true,
  },
}
export default {
  props,
  computed: {
    valueString() {
      return JSON.stringify(this.value, null, 2)
    },
  },
}
</script>
<style scoped>
pre {
  text-align: start;
}
</style>
