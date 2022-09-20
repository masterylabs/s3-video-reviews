<template>
  <div class="black white--text px-5 text-center body-2 py-1">
    {{ text }}
  </div>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: '',
    },
  },
}
</script>
