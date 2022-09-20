<template>
  <v-sheet min-width="327">
    <v-row class="mx-n1" no-gutters>
      <v-btn
        v-for="v in variants"
        :key="v.value"
        v-text="v.text"
        v-bind="{
          depressed: v.value === 'depressed',
          outlined: v.value === 'outlined',
          text: v.value === 'text',
        }"
        :color="value === v.value ? 'primary' : ''"
        small
        height="36"
        class="mx-1"
        @click="$emit('input', v.value)"
      />
    </v-row>
  </v-sheet>
</template>

<script>
  import variants from '../../templates/variants'
  export default {
    props: {
      value: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        variants,
      }
    },
  }
</script>
