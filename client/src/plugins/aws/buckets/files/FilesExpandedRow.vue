<template>
  <div class="mx-n4 row-container">
    <buckets-file-editor v-if="item.contentType === 'text'" v-bind="{ item }" />
    <buckets-image-editor
      v-else-if="item.contentType === 'image'"
      v-bind="{ item }"
    />
    <bucket-video v-else-if="item.contentType === 'video'" v-bind="{ item }" />
    <bucket-audio v-else-if="item.contentType === 'audio'" v-bind="{ item }" />
    <template v-else> DISABLE EXPAND: {{ item.contentType }} </template>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  mounted() {},
}
</script>

<style scoped>
.row-container {
  border-left: solid #f8f8f8 1px;
  border-right: solid #f8f8f8 1px;
}
</style>
