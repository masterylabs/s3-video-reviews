<template>
  <div>
    <m-tooltip v-for="item in items" :key="item.value" :value="item.text">
      <v-btn
        v-bind="{ large, xLarge }"
        :color="value === item.value ? 'primary' : 'grey'"
        :icon="!!item.icon"
        class="mr-1"
        @click="$emit('input', item.value)"
      >
        <v-icon v-if="item.icon" :size="item.iconSize"
          >mdi-{{ item.icon }}</v-icon
        >
        <span v-else v-text="item.text"></span>
      </v-btn>
    </m-tooltip>
  </div>
</template>

<script>
export default {
  props: {
    large: Boolean,
    xLarge: Boolean,
    value: {
      type: [String, Number],
      default: '',
    },
    items: {
      type: Array,
      required: true,
    },
  },
}
</script>
