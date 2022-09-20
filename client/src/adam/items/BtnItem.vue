<template>
  <div class="text-center">
    <v-btn v-bind="btn" @click.prevent="click">
      <span v-bind="btnText"><slot /></span>
    </v-btn>
  </div>
</template>

<script>
  import btnMixin from '../mixins/btn'
  export default {
    mixins: [btnMixin],
  }
</script>
