<template>
  <v-dialog v-model="dialog" width="340" :retain-focus="false" @input="input">
    <aws-buckets-card v-bind="{ title }">
      <slot />

      <template v-slot:actions>
        <slot name="actions" />
      </template>

      <template v-slot:append>
        <v-btn absolute right top icon class="mt-n1 mr-n1" @click="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </aws-buckets-card>
  </v-dialog>
</template>
<script>
export default {
  props: {
    title: String,
    value: Boolean,
  },
  data() {
    return {
      dialog: false,
    }
  },

  methods: {
    input() {
      this.$emit('input', this.dialog)
    },
    close() {
      this.dialog = false
      this.input()
    },
  },
  watch: {
    value(value) {
      this.dialog = value
    },
  },

  created() {
    if (this.value) {
      this.dialog = true
    }
  },
}
</script>
