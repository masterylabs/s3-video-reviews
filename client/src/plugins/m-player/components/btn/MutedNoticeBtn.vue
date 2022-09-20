<template>
  <div style="position:absolute;right:20px;top:20px;z-index:5000">
    <v-btn v-bind="btn" class="m-player-muted-notice-btn red" @click="click">
      <v-icon v-bind="icon" class="m-player-muted-notice-btn-icon" large
        >mdi-volume-off</v-icon
      >
    </v-btn>
  </div>
</template>

<script>
import btnMixin from '../../mixins/btn'
export default {
  mixins: [btnMixin],
}
</script>

<style scoped>
@keyframes shadow-pulse {
  0% {
    box-shadow: 0 0 0 0px rgba(255, 255, 255, 1);
  }
  100% {
    box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
  }
}

.m-player-muted-notice-btn {
  position: absolute;
  right: 30px;
  top: 30px;
  z-index: 0;
  @include border-radius(50%);
  animation: shadow-pulse 1s infinite;
}
.m-player-muted-notice-btn-icon {
  font-size: 36px;
}
</style>
