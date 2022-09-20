<template>
  <v-progress-circular
    class="loading-centered"
    indeterminate
    size="90"
    color="grey lighten-2"
  />
</template>

<style scoped>
.loading-centered {
  position: absolute;
  left: 50%;
  top: 50%;
  margin-top: -45px;
  margin-left: -45px;
}
</style>
