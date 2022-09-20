<template>
  <div>
    <v-btn
      v-for="item in getItems"
      :key="item.value"
      class="mr-2"
      depressed
      :loading="loading === item.value"
      :dark="item.dark"
      @click="item.click"
    >
      <v-icon class="mr-1">mdi-{{ item.icon || 'plus' }}</v-icon>
      {{ item.text }}
    </v-btn>
  </div>
</template>

<script>
import accessMixin from '@/mixins/access'

export default {
  mixins: [accessMixin],
  data() {
    return {
      loading: '',
      items: [
        {
          shortText: 'OTO',
          text: 'One Time Offer',
          value: 'oto',
          click: this.addOto,
          requires: 'otoAccess',
          icon: 'currency-usd',
        },
        {
          shortText: 'Thanks',
          text: 'Thank You Page',
          value: 'thanks',
          click: this.addThanks,
        },
        {
          shortText: 'Legal',
          text: 'Legal Page',
          value: 'legal',
          click: this.addLegal,
        },
      ],
    }
  },

  computed: {
    getItems() {
      return this.items.filter((item) => !item.requires || this[item.requires])
    },
  },

  methods: {
    async addThanks() {
      this.loading = 'thanks'
      await this.$store.dispatch('adam/addThanksPage')
      this.$store.dispatch('adam/refreshPages')
      this.loading = ''
    },
    async addLegal() {
      this.loading = 'legal'
      await this.$store.dispatch('adam/addLegalPage')
      this.$store.dispatch('adam/refreshPages')
      this.loading = ''
    },

    async addOto() {
      this.loading = 'oto'
      await this.$store.dispatch('adam/addOtoPage')
      this.$store.dispatch('adam/refreshPages')
      this.loading = ''
    },
  },
}
</script>
