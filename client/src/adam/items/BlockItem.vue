<template>
  <div class="block-item-container">
    <v-sheet v-bind="sheet" class="block-item">
      <!-- sheet: {{ sheet }} -->
      <v-row v-bind="row" :class="`pa-${theme.blockPadding}`" no-gutters>
        <slot />
      </v-row>
    </v-sheet>
  </div>
</template>

<script>
import sheetMixin from '../mixins/sheet'
import rowMixin from '../mixins/row'

export default {
  mixins: [
    //
    sheetMixin,
    rowMixin,
    // spacingMixin,
  ],
  mounted() {},
}
</script>
