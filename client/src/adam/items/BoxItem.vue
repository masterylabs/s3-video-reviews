<template>
  <v-col v-bind="col" :class="`py-${theme.boxPaddingY}`" class="box-item">
    <v-sheet v-bind="sheet">
      <slot />
    </v-sheet>
  </v-col>
</template>

<script>
import sheetMixin from '../mixins/sheet'
import colMixin from '../mixins/col'
export default {
  mixins: [sheetMixin, colMixin],
}
</script>
