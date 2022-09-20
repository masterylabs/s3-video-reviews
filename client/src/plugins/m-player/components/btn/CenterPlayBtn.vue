<template>
  <m-player-layer :max-height="maxHeight">
    <v-btn
      v-bind="btn"
      :class="rounded ? `rounded-${rounded}` : ''"
      @click="click"
    >
      <v-icon v-bind="icon" x-large v-text="icon.icon" />
    </v-btn>
  </m-player-layer>
</template>

<script>
  import btnMixin from '../../mixins/btn'
  export default {
    mixins: [btnMixin],
  }
</script>
