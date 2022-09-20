<template>
  <component :is="`adam-${type}-form`" v-bind="$props">
    <template v-if="children && children.length">
      <adam-panel-comp
        v-for="child in children"
        v-bind="child"
        :key="child.id"
      />
    </template>
  </component>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
    props: {
      type: Object,
      default: null,
    },
    opts: {
      type: Object,
      default: null,
    },
    children: {
      type: Array,
      default: null,
    },
    textContent: {
      type: String,
      default: null,
    },
  },
}
</script>
