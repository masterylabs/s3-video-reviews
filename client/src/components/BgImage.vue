<template>
  <v-img
    v-if="src"
    :src="src"
    class="offer-bg-image"
    :style="
      `filter:${this.filter};opacity:${opacity};transform: scale(${scale})`
    "
  />
</template>

<script>
  const getStrBetween = (str, a, b) => {
    if (!str) return ''

    let part = str.split(a)

    if (!part.length || typeof part[1] !== 'string') return ''

    part = part[1].split(b)

    return part ? part[0] : ''
  }
  export default {
    props: {
      src: {
        type: String,
        default: '',
      },
      filter: {
        type: String,
        default: '',
      },
      opacity: {
        type: [String, Number],
        default: 1,
      },
    },

    computed: {
      scale() {
        const n = getStrBetween(this.filter, 'blur(', 'p')

        if (!n) return 1

        return 1.05
      },
    },
  }
</script>

<style scoped>
  .offer-bg-image {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    filter: grayscale(0.5) brightness(1) blur(3px);
    opacity: 1;
    z-index: 0;
    transition: opacity 500ms;
    /* 
    transform: scale(1.05); */
    overflow: hidden;
  }
</style>
