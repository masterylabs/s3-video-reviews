import { mapGetters } from 'vuex'
import isDark from '../helpers/is-dark'
export default {
  computed: {
    ...mapGetters({
      appReady: 'ml/ready',
      m: 'ml/data',
      l: 'ml/layout',
      authenticated: 'ml/authenticated',
      hasAddon: 'ml/hasAddon',
    }),
    brandActive() {
      return this.m.brand && this.m.brand.active ? true : false
    },
    brandColor() {
      return this.m.brand && this.m.brand.color
        ? this.m.brand.color
        : this.m.app.color
    },
    brandDark() {
      return this.brandColor && isDark(this.brandColor) ? true : false
    },

    LANG_ITEM() {
      const active = this.m.brand && this.m.brand.active ? true : false
      return active && this.m.brand.item_text ? this.m.brand.item_text : 'Offer'
    },
    LANG_ITEMS() {
      const active = this.m.brand && this.m.brand.active ? true : false
      return active && this.m.brand.items_text
        ? this.m.brand.items_text
        : 'Offers'
    },
  },
}
