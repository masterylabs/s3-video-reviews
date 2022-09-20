<template>
  <div v-bind="attrs" class="ml-row">
    <slot />
  </div>
</template>

<script>
  import mlGridItemMixin from '../mixins/ml-grid-item'
  export default {
    mixins: [mlGridItemMixin],
  }
</script>
