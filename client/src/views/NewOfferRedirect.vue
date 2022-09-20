<template>
  <div></div>
</template>

<script>
export default {
  mounted() {
    const id = this.$route.params.id

    if (!id) {
      return this.$router.replace({ name: 'home' })
    }
    this.$router.replace({ name: 'offer', params: id })
  },
}
</script>
