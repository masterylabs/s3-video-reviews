<template>
  <div>
    <v-btn class="text-none primary--text" text @click="show = !show">{{
      value.DisplayName
    }}</v-btn>
    <code v-if="show">{{ value.ID }}</code>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      show: false,
    }
  },
}
</script>
