<template>
  <v-footer v-bind="sheet">
    <slot />
  </v-footer>
</template>

<script>
import sheetMixin from '../mixins/sheet'
export default {
  mixins: [sheetMixin],
}
</script>
