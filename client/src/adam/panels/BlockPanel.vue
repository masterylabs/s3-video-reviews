<template>
  <div>
    <slot />

    <adam-preview-layout class="mt-5">
      <adam-item v-bind="item" :theme="theme" is-preview />
    </adam-preview-layout>

    <v-expand-transition>
      <adam-timed-form
        v-if="timedAccess && item.opts.timed && canTimed"
        :id="id"
      />
    </v-expand-transition>

    <v-row no-gutters class="mt-5" align="center">
      <adam-timed-btn
        v-if="timedAccess"
        v-model="item.opts.timed"
        :disabled="!canTimed"
      />
      <v-spacer />

      <v-switch
        v-model="item.disabled"
        label="Disable"
        hide-details
        color="error"
        class="mt-0 mr-1"
      />

      <adam-chevron-toggle class="mx-2" v-model="show" />

      <adam-add-item-menu v-on="{ add }" />

      <adam-duplicate-btn class="ml-2" @click="duplicate" />
      <adam-remove-btn class="ml-2" @click="remove" />
    </v-row>

    <v-expand-transition>
      <adam-block-form v-if="show" :id="id" />
    </v-expand-transition>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import panelMixin from '../mixins/panel'
import { findItems } from '../helpers/find'
import colItems from '../templates/cols'
import accessMixin from '@/mixins/access'

export default {
  mixins: [panelMixin, accessMixin],
  data() {
    return {
      colItems,
      show: false,
      isCol: false,
      cols: [
        {
          text: 'Default Cols',
          value: 'cols',
        },
        {
          text: 'Mobile',
          value: 'cols',
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      theme: 'adam/theme',
    }),

    canTimed() {
      const videoIds = this.$store.getters['adam/videoIds']
      const childVideoIds = findItems(this.item.children, 'video').map(
        (v) => v.id
      )

      const nonChildVideos = videoIds.filter(
        (id) => childVideoIds.indexOf(id) < 0
      )

      return nonChildVideos.length > 0
      //   const vids = this.$store.getters['adam/videoIds']
      //   const childVids = findItems(this.item.children, 'video').map((v) => v.id)

      // const filter = (id) => {
      //   return childVids.indexOf(id) < 0
      // }
      //   return vids.filter((id) => childVids.indexOf(id) <script 0).length > 0
    },
  },

  methods: {
    ...mapActions({
      addBoxItem: 'adam/addBoxItem',
    }),
    remove() {
      this.$store.dispatch('adam/removeBlock', this.id)
      // this.$store.commit('adam/REMOVE', this.id)
    },
    duplicate() {
      this.$store.commit('adam/CLONE', this.id)
    },
    add({ type }) {
      this.addBoxItem({ id: this.id, type })
      // this.$store.commit('adam/ADD_BOX_ITEM', { id: this.id, type })
      // addBoxItem({ commit, state }, { id, type, children }) {
    },
  },
}
</script>
