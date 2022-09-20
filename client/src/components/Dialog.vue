<template>
  <v-dialog v-model="dialog" v-bind="{ persistent, width, transition }">
    <template v-slot:activator="e">
      <slot name="activator" v-bind="e" />
    </template>
    <v-card>
      <v-system-bar window dark color="secondary">
        <span class="ml-3">{{ title }}</span>
        <v-spacer></v-spacer>
        <v-icon @click="dialog = false">mdi-close</v-icon>
      </v-system-bar>
      <v-card-text>
        <slot />
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: {
    value: {
      type: Boolean,
      default: null,
    },
    persistent: Boolean,
    title: {
      type: String,
      default: '',
    },
    width: {
      type: [String, Number],
      default: 550,
    },
    transition: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      model: false,
      useModel: typeof this.value !== 'boolean',
    }
  },

  computed: {
    dialog: {
      get() {
        return this.useModel ? this.model : this.value
      },

      set(value) {
        if (this.useModel) {
          this.model = value
        } else {
          this.$emit('input', value)
        }
      },
    },
  },
}
</script>
