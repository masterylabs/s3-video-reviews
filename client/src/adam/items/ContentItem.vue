<template>
  <div>
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    theme: {
      type: Object,
      default: null,
    },
  },
}
</script>

<style>
.ql-align-center {
  text-align: center;
  margin: auto;
}
.ql-align-right {
  text-align: right;
}
.ql-align-left {
  text-align: left;
}
.ql-align-justify {
  text-align: justify;
}

.ql-size-small {
  letter-spacing: 0.0333333333em;
  font-size: 0.75rem;
}

.ql-size-large {
  letter-spacing: normal;
  font-size: 1.5rem;
}

.ql-size-huge {
  letter-spacing: -0.015625em;
  font-size: 2.125rem;
}
</style>
