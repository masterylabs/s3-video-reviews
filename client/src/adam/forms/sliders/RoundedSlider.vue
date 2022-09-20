<template>
  <v-slider
    v-model="model"
    label="Rounded"
    :max="5"
    thumb-label
    :hide-details="hideDetails"
    @input="onInput"
    @start="sliding = true"
    @end="sliding = false"
  >
    <template v-if="!noAppend" v-slot:append>
      <span class="primary--text text-uppercasex pt-1">
        {{ values[model] }}
      </span>
    </template>
  </v-slider>
</template>

<script>
  export default {
    props: {
      noAppend: Boolean,
      hideDetails: Boolean,
      value: {
        type: String,
        default: '',
      },
    },

    beforeMount() {
      if (this.value) this.setValue()
    },

    data() {
      return {
        model: 0,
        sliding: false,
        values: ['0', 'sm', 'lg', 'xl', 'pill', 'circle'],
      }
    },

    methods: {
      onInput(n) {
        const value = this.values[n]

        this.$emit('input', value)
      },
      setValue() {
        this.model = this.values.indexOf(this.value)
      },
    },

    watch: {
      value() {
        if (!this.sliding) this.setValue()
      },
    },
  }
</script>
