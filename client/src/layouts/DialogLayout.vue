<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500" @input="input">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          v-bind="{ ...attrs, color, outlined, depressed, text }"
          v-on="on"
        >
          <v-icon v-if="icon" class="mr-1" v-text="`mdi-${icon}`"></v-icon>
          {{ btnText }}
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="title grey lighten-3 mb-5 pb-4">
          {{ title }}
        </v-card-title>

        <v-card-text>
          <slot />
        </v-card-text>

        <v-divider></v-divider>

        <v-btn icon absolute right top large class="mt-n2" @click="toggle">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        type: Boolean,
        default: false,
      },
      title: {
        type: String,
        default: '',
      },
      btnText: {
        type: String,
        default: '',
      },
      color: {
        type: String,
        default: '',
      },
      icon: {
        type: String,
        default: '',
      },
      text: Boolean,
      outlined: Boolean,
      depressed: Boolean,
    },
    data() {
      return {
        dialog: false,
      }
    },

    created() {
      this.dialog = this.value
    },

    methods: {
      toggle() {
        this.dialog = !this.dialog
        this.input(this.dialog)
      },
      input(value) {
        this.$emit('input', value)
      },
    },

    watch: {
      value(value) {
        if (value !== this.dialog) {
          this.toggle()
        }
      },
    },
  }
</script>
