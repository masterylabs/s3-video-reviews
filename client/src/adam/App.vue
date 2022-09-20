<template>
  <ml-app auth activate>
    <admin-layout>
      <router-view />
    </admin-layout>
  </ml-app>
</template>
<script>
  export default {
    watch: {
      $route(to) {
        this.show = false
        if (window.parent)
          window.parent.postMessage(`ml_route_to_${to.path}`, '*')
      },
    },
  }
</script>
