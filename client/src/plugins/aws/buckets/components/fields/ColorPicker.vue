<template>
  <v-row dense>
    <v-col v-for="color in colors" :key="color" cols="2">
      <v-card
        v-bind="{ color }"
        height="24"
        flat
        class="text-center"
        dark
        @click="select(color)"
      >
        <v-icon v-if="value === color">mdi-check-bold</v-icon>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      colors: [
        '#F44336',
        '#E91E63',
        '#9C27B0',
        '#673AB7',
        '#3F51B5',
        '#1A237E',
        '#2196F3',
        '#03A9F4',
        '#00BCD4',
        '#009688',
        '#4CAF50',
        '#1B5E20',
        '#8BC34A',
        '#CDDC39',
        '#decb23',
        '#FFC107',
        '#FF9800',
        '#795548',
        '#F37C23',
        '#FF5722',
        '#78909C',
        '#4A5460',
        '#232F3E',
        '#000000',
      ],
    }
  },

  methods: {
    select(color) {
      if (color === this.value) {
        color = ''
      }
      this.$emit('input', color)
    },
  },
}
</script>
