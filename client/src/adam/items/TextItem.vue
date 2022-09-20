<template>
  <div v-bind="text">
    <span :class="highlight ? 'yellow lighten-3 px-1' : ''"><slot /></span>
  </div>
</template>

<script>
import textMixin from '../mixins/text'

export default {
  mixins: [textMixin],
}
</script>
