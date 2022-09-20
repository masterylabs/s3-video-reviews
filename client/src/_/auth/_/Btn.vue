<template>
  <button v-bind="getAttrs" class="ml-btn">
    <slot />
  </button>
</template>

<script>
  import mlGridItemMixin from '../mixins/ml-grid-item'

  const defaultValues = {}

  export default {
    props: {
      small: Boolean,
      medium: Boolean,
      large: Boolean,
    },
    mixins: [mlGridItemMixin],
    computed: {
      getAttrs() {
        const attrs = { ...this.attrs }

        return attrs
      },
    },
  }
</script>
