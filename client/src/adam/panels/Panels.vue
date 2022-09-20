<template>
  <div>
    <component
      :is="`adam-${item.type}-panel`"
      v-for="(item, index) in panels"
      :key="item.id"
      :id="item.id"
    >
      <v-expansion-panels v-model="panel[index]">
        <v-expansion-panel v-if="index === 0" @change="onPanel('setup')">
          <v-expansion-panel-header class="text-capitalize">
            Setup
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <!-- {{ pageType }} -->
            <component :is="`adam-${pageType}-form`" />
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel
          v-for="(child, childIndex) in item.children"
          :key="child.id"
          @change="onPanel('content')"
        >
          <drag-drop :index="childIndex" @drag-drop="onDrop(index, $event)">
            <adam-panel-header
              :disabled="child.disabled"
              :timed="child.opts.timed"
              draggable
            >
              {{ child.name || child.type }}
            </adam-panel-header>
          </drag-drop>

          <v-expansion-panel-content>
            <adam-panel v-bind="child" />
          </v-expansion-panel-content>
        </v-expansion-panel>

        <!-- <adam-footer-panel /> -->

        <!-- APPEND PANELS  -->
        <v-expansion-panel
          v-for="(pan, i) in append"
          :key="pan.value"
          v-on="pan.on"
          @change="onPanel(pan.value)"
        >
          <v-expansion-panel-header>
            {{ pan.text }}
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <component
              :is="`adam-${pan.value}-form`"
              :active="i === append.length - 1"
            />
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </component>

    <!-- <dev-raw :value="panels" /> -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      isBg: false,
      panelIdCountSet: false,
      prependPanels: ['offer'],
    }
  },

  computed: {
    ...mapGetters({
      panels: 'adam/panels',
      isChild: 'adam/isChild',
      append: 'adam/appendPanels',
      bgImage: 'layout/bgImage',
      pageType: 'adam/pageType',
      bg: 'adam/bg',
    }),
    panel: {
      get() {
        return this.$store.state.adam.panel
      },
      set(panel) {
        this.$store.commit('adam/SET', { panel })
      },
    },
  },
  methods: {
    ...mapActions({
      setBgPreview: 'adam/setBgPreview',
    }),
    onPanel(value) {
      if (value === 'bg') {
        this.isBg = !this.isBg
        this.setBgPreview(this.isBg)
      } else if (this.isBg) {
        this.isBg = false
        this.setBgPreview(false)
      }
    },
    // panel index, from to
    onDrop(index, { from, to }) {
      const fromId = this.panels[index].children[from].id
      const n = to - from
      this.$store.commit('adam/MOVE', [fromId, n])
    },

    addBlock(id) {
      this.$store.commit('adam/ADD_BLOCK', id)
    },
  },

  beforeDestroy() {
    if (this.isBg) {
      this.setBgPreview(false)
    }
  },
}
</script>
