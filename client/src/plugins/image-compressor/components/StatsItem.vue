<template>
  <div class="mx-3">
    <div>
      <slot />
    </div>
    <div class="body-2 text-uppercase caption">{{ name }}</div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: '',
    },
  },
}
</script>
