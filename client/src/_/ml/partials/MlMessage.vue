<template>
  <div>
    <v-scale-transition group origin="bottom center 0">
      <v-snackbar
        v-for="(m, i) in messages"
        :key="m.id"
        :color="m.name"
        :value="true"
        fixed
        class="message"
        :style="`margin-bottom:${i * 54}px;`"
      >
        {{ m.text }}
        <template v-slot:action="{ attrs }">
          <v-btn text v-bind="attrs" @click="close(m.id)">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-scale-transition>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      messages: 'ml/messages',
    }),
  },

  methods: {
    close(id) {
      this.$store.commit('ml/CLOSE_MESSAGE', id)
    },
  },
}
</script>

<style scoped>
.message {
  transition: margin 600ms;
}
</style>
