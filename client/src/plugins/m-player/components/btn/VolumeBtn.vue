<template>
  <v-btn v-bind="btn" @click="click">
    <v-icon v-bind="icon" v-text="icon.icon" />
  </v-btn>
</template>

<script>
import btnMixin from '../../mixins/btn'
export default {
  mixins: [btnMixin],
}
</script>
