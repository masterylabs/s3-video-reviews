<template>
  <div class="text-center">
    <a v-if="src" @click.prevent="click">
      <img :src="src" alt="" />
    </a>
    <v-btn v-else v-bind="btn" @click="click">
      <v-icon v-if="cart" v-bind="btnIcon" class="mr-2 ml-n2">mdi-cart</v-icon>
      <span v-bind="btnText"><slot /></span>
    </v-btn>

    <v-row
      v-if="cards || paypal"
      align="center"
      justify="center"
      no-gutters
      :class="`mt-${cards ? 4 : 2}`"
    >
      <img
        v-for="card in getCards"
        :key="card"
        :src="`${publicUrl}/images/cards/${card}.svg`"
        :style="`height: ${cards ? 24 : 40}px`"
        class="mx-1"
      />
    </v-row>
  </div>
</template>

<script>
import btnMixin from '../mixins/btn'
import publicUrlMixin from '../mixins/public-url'

export default {
  mixins: [btnMixin, publicUrlMixin],
  props: {
    cart: Boolean,
    cards: Boolean,
    paypal: Boolean,
  },
  data() {
    return {
      cardItems: [
        //
        'visa',
        'mastercard',
        'amex',
        'discovery',
      ],
    }
  },

  computed: {
    getCards() {
      if (!this.cards && this.paypal) {
        return ['paypal']
      }
      const items = [...this.cardItems]
      if (this.paypal) items.push('paypal')
      return items
    },
  },
}
</script>
