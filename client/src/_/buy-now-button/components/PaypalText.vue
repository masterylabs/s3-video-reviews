<template>
  <div class="font-italic font-weight-bold" style="font-size:20px">
    <span :style="`color:#${primaryColor};margin-right:1px`">Pay</span>
    <span :style="`color:${secondaryColor}`">Pal</span>
  </div>
</template>

<script>
  export default {
    props: {
      primaryColor: {
        type: String,
        default: '#053087',
      },
      secondaryColor: {
        type: String,
        default: '#2B9CDE',
      },
    },
  }
</script>
