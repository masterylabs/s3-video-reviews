// TODO: access changed to new version

export default {
  computed: {
    access() {
      const config = this.$store.getters.config

      return config.access ? config.access : {}
    },
    developerAccess() {
      return this.access.developer
      // return this.hasAddon.developer && !this.m.isBrandClient
    },

    premiumAccess() {
      return this.access.premium
      // return this.hasAddon.premium ? true : false
    },
    settingsAccess() {
      return true
      // if (this.brandActive && this.m.isBrandClient)
      // return !!this.m.brand.allow_settings

      // return true
    },
    timedAccess() {
      // return false
      return this.access.premium || this.access.timed ? true : false
      // if (this.brandActive) return !!this.m.brand.allow_timed
      // return this.hasAddon.timed || this.hasAddon.premium ? true : false
    },
    upgradeAccess() {
      return this.access.premium || this.access.upgrade ? true : false
      // if (this.brandActive) return !!this.m.brand.allow_upgrade
      // return this.hasAddon.upgrade || this.hasAddon.premium ? true : false
    },
    otoAccess() {
      return this.access.premium || this.access.oto ? true : false
      // if (this.brandActive) return !!this.m.brand.allow_oto
      // return this.hasAddon.oto || this.hasAddon.premium ? true : false
    },
    darkAccess() {
      return this.access.premium || this.access.dark ? true : false
      // if (this.brandActive) return !!this.m.brand.allow_dark
      // return this.hasAddon.dark || this.hasAddon.premium ? true : false
    },

    brandLogo() {
      return false
      // return this.brandActive && this.m.brand.business_logo
      //   ? this.m.brand.business_logo
      //   : ''
    },

    brandLink() {
      return false
      // return this.brandActive && this.m.brand.business_link
      //   ? this.m.brand.business_link
      //   : ''
    },
  },
}
