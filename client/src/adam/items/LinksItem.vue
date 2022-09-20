<template>
  <v-row v-bind="row" class="my-0">
    <slot />
  </v-row>
</template>

<script>
import rowMixin from '../mixins/row'

export default {
  mixins: [rowMixin],
}
</script>
