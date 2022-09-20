<template>
  <div>
    <v-tooltip :left="tooltipLeft" :disabled="confirm || !tooltip">
      <template v-slot:activator="{ on, attrs }">
        <div v-on="on" v-bind="attrs">
          <v-btn
            v-bind="{ absolute, right, bottom, dark }"
            :color="confirm ? 'error' : color ? color : ''"
            :depressed="!confirm"
            :loading="loading || deleting"
            :disabled="disabled"
            :icon="icon && !confirm"
            @click="submit"
          >
            <v-icon v-if="icon && !confirm">mdi-delete</v-icon>
            <slot v-else>{{
              confirm ? m.lang.DELETE_CONFIRM_BTN : m.lang.DELETE_BTN
            }}</slot>
          </v-btn>
          <v-btn
            v-if="confirm"
            :disabled="loading"
            v-text="m.lang.CANCEL_BTN"
            depressed
            class="ml-2"
            @click="confirm = false"
          />
        </div>
      </template>
      <span v-text="m.lang.DELETE_BTN" />
    </v-tooltip>
  </div>
</template>

<script>
export default {
  props: {
    icon: Boolean,
    absolute: Boolean,
    disabled: Boolean,
    bottom: Boolean,
    right: Boolean,
    dark: Boolean,
    tooltipLeft: Boolean,
    tooltip: [Boolean, String],
    emitDelete: Boolean,
    deleting: Boolean,
    url: {
      type: String,
      default: '',
    },
    endpoint: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: '',
    },
    deletedRoute: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      confirm: false,
      loading: false,
    }
  },

  methods: {
    async submit() {
      if (!this.confirm) return (this.confirm = true)

      if (this.emitDelete) {
        this.$emit('delete')
        return (this.confirm = false)
      }

      this.loading = true

      const url = this.url ? this.url : `${this.endpoint}/delete`

      await this.$app.post(url)

      this.loading = false

      if (this.deletedRoute) {
        return this.$router.replace({ name: this.deletedRoute })
      }
      this.$emit('deleted')
    },
  },
}
</script>
