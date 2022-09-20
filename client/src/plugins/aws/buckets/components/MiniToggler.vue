<template>
  <div v-on="{ click }" class="ml-pointer ml-no-select">
    <v-icon
      v-text="value ? 'mdi-toggle-switch' : 'mdi-toggle-switch-off'"
      :color="value ? 'primary' : 'grey'"
      size="30"
    ></v-icon>
    <span v-if="label" class="body-2 ml-1 grey--text text--darken-3">{{
      label
    }}</span>
  </div>
</template>
<script>
export default {
  props: {
    value: Boolean,
    label: {
      type: String,
      default: '',
    },
  },

  methods: {
    click() {
      this.$emit('input', !this.value)
    },
  },
}
</script>
