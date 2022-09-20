<template>
  <div>
    <adam-input-toggle-field
      v-model="model"
      v-bind="{ focused }"
      multiple
      :items="items"
    />
  </div>
</template>

<script>
  export default {
    props: {
      focused: Boolean,
    },
    data() {
      return {
        model: [],
        items: [
          {
            // text: 'XS',
            icon: 'cart',
            value: 'cart',
          },
          {
            icon: 'credit-card-outline',
            value: 'medium',
          },
          {
            text: 'PP',
            value: 'small',
          },
        ],
      }
    },
  }
</script>
