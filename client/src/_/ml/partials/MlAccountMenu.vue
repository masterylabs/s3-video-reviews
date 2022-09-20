<template>
  <div>
    <ml-menu v-bind="getMenu" />

    <dialog-layout v-model="isUpdateLicense" persistent>
      <br />
      <m-update-license />
    </dialog-layout>

    <dialog-layout v-model="isViewLicense">
      <br />
      <m-license-plark />
    </dialog-layout>
  </div>
</template>

<script>
  // import {mapMutations} from 'vuex'
  export default {
    props: {
      members: Boolean,
      // what is available, logout, my account, my proudcts, update license
    },
    data() {
      return {
        isUpdateLicense: false,
        isViewLicense: false,
        menu: {
          avatar: '',
          items: [
            {
              text: 'License',
              icon: 'mdi-license',
              items: [
                {
                  text: 'View License',
                  icon: 'mdi-license',
                  click: () => (this.isViewLicense = true),
                },
                {
                  text: 'Update License',
                  icon: 'mdi-license',
                  click: () => (this.isUpdateLicense = true),
                },
              ],
            },
            // {
            //   text: 'Branding',
            //   icon: 'mdi-storefront',
            //   // click: () => this.setView('developer'),
            // },
          ],
        },
      }
    },
    computed: {
      getMenu() {
        const menu = { ...this.menu }

        // avatar
        if (
          this.m.license &&
          this.m.license.contact &&
          this.m.license.contact.avatar
        )
          menu.avatar = this.m.license.contact.avatar

        return menu
      },
    },

    methods: {
      setView(name) {
        this.$store.dispatch('ml/setView', name)
      },
    },
  }
</script>
