<template>
  <component :is="`adam-${type}-${getType}`" v-bind="$props" class="pt-2">
    <template v-if="children && children.length">
      <adam-panel
        v-for="(child, i) in children"
        :index="i"
        :last="i === children.length - 1"
        v-bind="child"
        :key="child.id"
      />
    </template>
  </component>
</template>

<script>
export default {
  props: {
    last: Boolean,
    index: {
      type: Number,
      default: null,
    },
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

  computed: {
    getType() {
      return ['section', 'block', 'box'].includes(this.type) ? 'panel' : 'form'
    },
  },
}
</script>
