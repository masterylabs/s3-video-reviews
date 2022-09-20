<template>
  <v-text-field
    ref="input"
    v-bind="{ value, hideDetails }"
    :label="m.lang[label]"
    placeholder="https://"
    outlined
    :class="isDisabled ? 'input-disabled' : ''"
    @input="$emit('input', $event)"
    @focus="focused = true"
    @blur="focused = false"
  >
    <template v-slot:append>
      <m-tooltip value="Open In New Window">
        <v-icon :color="openNew ? 'success' : 'grey'" @click="onOpenNew"
          >mdi-open-in-new</v-icon
        >
      </m-tooltip>
      <m-tooltip value="Use Checkout URL">
        <v-btn
          small
          class="ml-2"
          style="margin-top: -2px"
          depressed
          :color="checkout ? 'success' : ''"
          @click="onCheckout"
          >Checkout</v-btn
        >
      </m-tooltip>
    </template>
  </v-text-field>
</template>

<script>
export default {
  props: {
    openNew: Boolean,
    disabled: Boolean,
    checkout: Boolean,
    value: {
      type: String,
      default: '',
    },
    hideDetails: Boolean,
    label: {
      type: String,
      default: 'LINK_FIELD',
    },
    // secondary: {
    //   type: Boolean,
    //   default: false,
    // },
  },

  data() {
    return {
      focused: false,
    }
  },

  computed: {
    isDisabled() {
      return this.disabled || this.checkout
    },
  },

  methods: {
    onOpenNew() {
      this.$emit('openNew', !this.openNew)
    },
    onCheckout() {
      this.$emit('checkout', !this.checkout)
    },
    onCheckoutBlur() {
      setTimeout(() => {
        if (!this.checkout) {
          this.$refs.input.focus()
        }
      }, 50)
    },
  },
}
</script>
