<template>
  <v-scale-transition group origin="bottom center 0">
    <v-snackbar
      v-for="(m, i) in items"
      :key="m.id"
      :color="m.name"
      :value="true"
      fixed
      class="message"
      :style="`margin-bottom:${i * 54}px;`"
    >
      {{ m.text }}
      <template v-slot:action="{ attrs }">
        <v-btn text v-bind="attrs" @click="close(m.id)"> Close </v-btn>
      </template>
    </v-snackbar>
  </v-scale-transition>
</template>

<script>
export default {
  computed: {
    items() {
      return this.$store.state.message.items
    },
  },
  methods: {
    close(id) {
      this.$store.dispatch('message/closeItem', id)
    },
  },
}
</script>
