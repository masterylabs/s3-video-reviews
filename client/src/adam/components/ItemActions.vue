<template>
  <v-sheet min-width="250">
    <v-row no-gutters justify="end">
      <slot name="prepend" />
      <adam-chevron-toggle
        v-if="useToggle"
        class="ml-2"
        v-bind="{ value }"
        v-on="{ input }"
      />
      <slot name="prepend-inner" />

      <adam-move-up-btn :disabled="first" class="ml-2" @click="moveUp" />
      <adam-move-down-btn :disabled="last" @click="moveDown" />
      <adam-duplicate-btn class="ml-2" @click="duplicate" />
      <adam-remove-btn class="ml-2" @click="remove" />
    </v-row>
  </v-sheet>
</template>

<script>
  export default {
    props: {
      value: {
        type: Boolean,
        default: null,
      },
      id: {
        type: String,
        required: true,
      },
      first: Boolean,
      last: Boolean,
    },

    computed: {
      useToggle() {
        return this.value !== null
      },
    },

    methods: {
      input() {
        this.$emit('input', !this.value)
      },
      moveUp() {
        this.$store.commit('adam/MOVE_UP', this.id)
      },

      moveDown() {
        this.$store.commit('adam/MOVE_DOWN', this.id)
      },
      duplicate() {
        this.$store.commit('adam/CLONE', this.id)
      },
      remove() {
        this.$store.commit('adam/REMOVE', this.id)
      },
    },
  }
</script>
