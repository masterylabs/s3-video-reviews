<template>
  <v-btn v-bind="{ disabled }" v-on="{ click }" icon>
    <v-icon>mdi-arrow-down</v-icon>
  </v-btn>
</template>

<script>
  import buttonMixin from '../../mixins/form-btn'
  export default {
    mixins: [buttonMixin],
  }
</script>
