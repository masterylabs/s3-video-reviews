<template>
  <div v-bind="attrs" class="ml-col">
    <!-- {{ attrs }} -->
    <slot />
  </div>
</template>

<script>
  import mlGridItemMixin from '../mixins/ml-grid-item'
  export default {
    mixins: [mlGridItemMixin],
  }
</script>
