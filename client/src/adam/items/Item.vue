<template>
  <component
    :is="`adam-${type}-item`"
    v-bind="getProps"
    :id="id"
    :is-preview="isPreview"
    :theme="theme"
    v-on="{ message }"
  >
    {{ textContent || '' }}
    <span v-if="htmlContent" v-html="htmlContent" />
    <adam-item
      v-for="child in getChildren"
      v-bind="child"
      :is-preview="isPreview"
      :theme="theme"
      :key="child.id"
      v-on="{ message }"
    >
    </adam-item>
  </component>
</template>

<script>
import { jsonClense } from '../helpers/obj'
export default {
  props: {
    isPreview: Boolean,
    disabled: Boolean,
    id: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
    props: {
      type: Object,
      default: null,
    },
    opts: {
      type: Object,
      default: null,
    },
    children: {
      type: Array,
      default: null,
    },
    textContent: {
      type: String,
      default: null,
    },
    htmlContent: {
      type: String,
      default: null,
    },
    theme: {
      type: Object,
      default: null,
    },
    childProps: {
      type: Object,
      default: null,
    },
  },

  computed: {
    getProps() {
      if (!this.props) return null

      if (!this.opts) return this.props

      const props = { ...this.props }

      for (const k in this.opts) {
        if (!this.opts[k] && props[k]) {
          delete props[k]
        }
      }

      if (this.propChildren) {
        props.children = this.children
      }

      if (this.type === 'custom-html') {
        props.htmlContent = this.htmlContent
      }

      return props
    },

    getChildren() {
      if (!this.children || !this.children.length) return []

      return this.children.map((item) => {
        if (this.childProps) {
          if (this.isPreview) {
            item = jsonClense(item)
          }

          for (const k in this.childProps) {
            if (this.childProps[k] && !item.props[k]) {
              item.props[k] = this.childProps[k]
            }
          }
        }
        return item
      })
    },
  },

  methods: {
    message(e) {
      this.$emit('message', e)
    },
  },

  mounted() {
    //
    //   type: this.type,
    //   props: this.props,
    //   childProps: this.childProps,
    // })
  },
}
</script>
