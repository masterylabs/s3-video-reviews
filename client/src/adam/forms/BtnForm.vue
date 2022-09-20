<template>
  <adam-form-layout v-bind="{ more, color }">
    <template v-slot:main>
      <v-col cols="12" :md="item.opts.src ? 4 : 6">
        <v-text-field
          v-model="item.textContent"
          :label="label"
          :autofocus="!item.textContent"
          hide-details
          outlined
          @focus="focused = true"
          @blur="focused = false"
        >
          <template v-slot:prepend-inner>
            <adam-menu-toggle v-model="more" v-bind="{ focused }" />
          </template>

          <template v-slot:append>
            <slot name="text-append" v-bind="{ focused }" />
          </template>
        </v-text-field>
      </v-col>

      <v-col v-if="item.opts.src" cols="12" :md="item.opts.src ? 4 : 6">
        <v-text-field
          v-model="item.props.src"
          label="Image"
          hide-details
          :autofocus="!item.props.src"
          outlined
        >
          <template v-slot:append>
            <adam-media v-model="item.props.src" />
          </template>
        </v-text-field>
      </v-col>
      <v-col>
        <adam-link-field
          v-model="item.props.href"
          v-bind="linkField"
          v-on="{ checkout, openNew }"
          hide-details
        />
      </v-col>
    </template>

    <adam-color-bar
      v-if="!item.opts.src"
      v-model="item.props.color"
      opacity
      slot="color"
    />

    <template v-slot:more>
      <adam-variant-field
        v-model="item.props.variant"
        class="mt-2 mr-2"
        :disabled="item.opts.src"
      />
      <adam-size-field
        v-model="item.props.size"
        class="mt-2 mr-2"
        :disabled="item.opts.src"
      />

      <adam-justify-field v-model="item.props.justify" class="mt-2 mr-2" />

      <adam-icon-btn
        is-toggle
        v-model="color"
        icon="palette"
        :disabled="item.opts.src"
      />
      <v-switch
        v-model="item.opts.src"
        label="Own Button"
        class="mt-0 ml-4 mr-2"
        hide-details
      />
      <v-switch
        v-model="item.props.dark"
        :disabled="item.props.light || item.opts.src"
        label="Dark"
        class="mt-0 mx-2"
        hide-details
      />
      <v-switch
        v-model="item.props.light"
        :disabled="item.props.dark || item.opts.src"
        label="Light"
        class="mt-0 mx-2"
        hide-details
      />

      <v-spacer />
      <slot name="more-append" />
    </template>

    <template v-slot:parent-actions>
      <slot name="actions" />
    </template>

    <slot />
  </adam-form-layout>
</template>

<script>
import formMixin from '../mixins/form'
import textFormatMixin from '../mixins/form-text-format'
import linkFieldMixin from '../mixins/link-field'
import align from '../templates/text-align'

// btn
import sizes from '../templates/sizes'

export default {
  mixins: [formMixin, textFormatMixin, linkFieldMixin],
  props: {
    parentId: {
      type: String,
      default: null,
    },
    label: {
      type: String,
      default: 'Button Text',
    },
  },

  data() {
    return {
      focused: false,
      color: false,
      more: false,
      align,
      sizes,
      options: [
        {
          text: 'Custom Width',
          value: 'width',
          min: 100,
          max: 700,
        },
        {
          text: 'Custom Height',
          value: 'height',
          min: 20,
          max: 200,
        },
        {
          text: 'Custom Text Size',
          value: 'fontSize',
          min: 10,
          max: 100,
        },
      ],
    }
  },

  computed: {
    optSliders() {
      return this.options.filter(
        ({ value }) =>
          this.item.opts[value] && (!this.item.props.block || value !== 'width')
      )
    },
  },

  // methods: {
  //   checkout(value) {
  //     this.item.props.checkout = value
  //   },
  //   openNew(value) {
  //     this.item.props.openNew = value
  //   },
  // },
}
</script>
