<template>
  <div
    class="m-player-layer m-player-preview-mask"
    v-on:click="$emit('click')"
  />
</template>

<style scoped>
.m-player-preview-mask {
  cursor: pointer;
  pointer-events: auto;
}
</style>
