<template>
  <div class="text-center ma-2">
    <v-snackbar
      v-model="snackbar"
      v-bind="{ timeout }"
      right
      bottomx
      top
      light
      color="grey lighten-5"
      class="mt-2"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          colorx="grey lighten-4"
          depressed
          v-bind="attrs"
          @click="onCancel"
        >
          Undo
        </v-btn>
        <v-btn icon class="ml-3" @click="snackbar = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    data: () => ({
      timeout: 7000,
      snackbar: false,
      text: `Item Removed!`,
    }),

    methods: {
      onCancel() {
        this.$store.commit('adam/RESTORE_REMOVED')
        this.snackbar = false
      },
    },

    mounted() {
      this.$store.subscribe(({ type }) => {
        if (type === 'adam/REMOVE') {
          this.snackbar = true
        }
      })
    },
  }
</script>
