<template>
  <div>
    <slot />

    <v-row class="mt-4" no-gutters align="center">
      <adam-add-item-menu v-on="{ add }" />

      <v-spacer />
      <template v-if="pageType !== 'offer'">
        <v-switch
          v-for="option in options"
          :key="option.value"
          v-model="opts[option.value]"
          :label="option.text"
          hide-details
          class="mt-0 mr-4"
          @change="onOption(option.value, $event)"
        />
      </template>

      <!-- opts: {{ opts }} -->

      <adam-add-upgrade-btn v-if="showUpgradeBtn" :section-id="id" />
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import panelMixin from '../mixins/panel'
import accessMixin from '@/mixins/access'
export default {
  mixins: [accessMixin, panelMixin],
  data() {
    return {
      options: [
        {
          text: 'Own Footer',
          value: 'footer',
          hasPanel: true,
        },
        {
          text: 'Own Design',
          value: 'theme',
        },
        {
          text: 'Own Background',
          value: 'bg',
          hasPanel: true,
        },
        {
          text: 'Own Advanced',
          value: 'advanced',
          hasPanel: true,
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      panels: 'adam/panels',
      newPanelIndex: 'adam/newPanelIndex',
      opts: 'adam/opts',
      pageType: 'adam/pageType',
      isChild: 'adam/isChild',
    }),
    showUpgradeBtn() {
      return this.upgradeAccess && this.pageType !== 'legal' ? true : false
    },
  },

  methods: {
    add({ type, name }) {
      this.$store.dispatch('adam/addSectionItem', { id: this.id, type, name })
    },

    onOption(key, v) {
      const option = this.options.find(({ value }) => value === key)
      if (!option.hasPanel) {
        return
      }

      let n = this.newPanelIndex

      if (v) {
        n++
      } else {
        n--
      }

      this.$store.commit('adam/SET', { newPanelIndex: n })
    },
  },

  mounted() {
    let newPanelIndex = this.panels[0].children.length + 1

    // no parent
    if (!this.isChild) {
      newPanelIndex += this.options.filter((a) => a.hasPanel).length + 1
    } else {
      this.options.forEach(({ value }) => {
        if (this.opts[value]) {
          newPanelIndex++
        }
      })
    }

    this.$store.commit('adam/SET', { newPanelIndex })
  },
}
</script>
