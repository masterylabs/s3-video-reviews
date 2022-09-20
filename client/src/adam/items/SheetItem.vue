<template>
  <v-sheet v-bind="sheet" class="mx-auto sheet" :class="spacingClasses">
    <slot />
  </v-sheet>
</template>

<script>
  import sheetMixin from '../mixins/sheet'
  export default {
    mixins: [sheetMixin],
  }
</script>
<style scoped>
  .sheet {
    transition: all 0.3s ease;
  }
</style>
