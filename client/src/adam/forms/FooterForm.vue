<template>
  <div>
    <component
      :is="`adam-${child.type}-container`"
      v-for="(child, i) in item.children"
      :key="child.id"
      v-bind="child"
      :last="i === item.children.length - 1"
      :first="i === 0"
    />

    <adam-preview-layout class="mt-5">
      <adam-item v-bind="previewItem" :theme="theme" is-preview />
    </adam-preview-layout>

    <v-row no-gutters class="mt-5" align="center">
      <adam-add-item-menu v-on="{ add }" />
      <v-spacer />

      <v-switch
        v-model="item.disabled"
        label="Disable"
        hide-details
        color="error"
        class="mt-0"
      />
      <adam-chevron-toggle class="mx-2" v-model="show" />
    </v-row>

    <v-expand-transition>
      <div v-if="color">
        <adam-color-bar class="my-4" v-model="item.props.color" opacity />
      </div>
    </v-expand-transition>

    <v-expand-transition>
      <adam-sheet-form v-if="show" :id="item.id">
        <template v-slot:append>
          <v-row align="center" class="my-0">
            <v-col>
              <adam-col-slider label="Column" v-model="item.childProps.cols" />
            </v-col>
            <v-col>
              <adam-col-slider
                label="Offset"
                max="11"
                v-model="item.childProps.offset"
              />
            </v-col>
          </v-row>
        </template>
      </adam-sheet-form>
    </v-expand-transition>
  </div>
</template>

<script>
  import { findItem } from '../helpers/find'
  import previewMixin from '../mixins/preview'
  export default {
    mixins: [previewMixin],
    data() {
      return {
        show: false,
        color: false,
      }
    },

    computed: {
      item: {
        get() {
          return findItem(
            this.$store.getters['adam/page'].body,
            'footer',
            'type'
          )
        },
      },
      theme() {
        return this.$store.getters['adam/theme']
      },
      linksId() {
        const item = this.item.children.find((a) => a.type === 'links')
        return item ? item.id : ''
      },
    },
    methods: {
      testClick() {
        this.add({ type: 'links' })
      },
      add({ type }) {
        this.$store.dispatch('adam/addBoxItem', { id: this.item.id, type })
      },

      resetFooter() {
        this.$store.getters['adam/page'].body.children[0] = {
          id: 'footer',
          type: 'footer',
          props: {},
          opts: {},
          children: [],
          disabled: false,
        }

        this.$store.dispatch('adam/addBoxItem', { id: 'footer', type: 'links' })
        // this.$store.dispatch('adam/addChild', { id: 'footer', type: 'links' })
      },
    },

    mounted() {
      // this.testClick()
    },

    created() {
      if (!this.item) {
        this.$store.getters['adam/page'].body.children.push({
          id: 'footer',
          type: 'footer',
          props: {},
          opts: {},
          children: [],
          disabled: false,
        })
      }
    },
  }
</script>
