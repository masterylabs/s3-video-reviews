<template>
  <div class="drag-overlay-container">
    <v-container fill-height>
      <v-row justify="center">
        <div class="text-h3 white--text font-weight-bold animate-flicker">
          DROP IT!
        </div>
      </v-row>
    </v-container>
  </div>
</template>

<style scoped>
/* Changed For Adam */
.drag-overlay-container {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  outline: dashed 8px #23a7f3;
  background-color: rgba(55, 55, 54, 0.546);
  text-shadow: 2px 2px #000000;
  pointer-events: none;
  opacity: 0.7;
}

@keyframes flickerAnimation {
  0% {
    transform: scale(1);
  }
  60% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.animate-flicker {
  animation: flickerAnimation 1.7s infinite;
}
</style>
