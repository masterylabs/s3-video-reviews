<template>
  <adam-form-layout v-bind="{ more }">
    <template v-slot:main>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="item.props.src"
          label="Image"
          placeholder="https://"
          hide-details
          outlined
        >
          <template v-slot:prepend-inner>
            <adam-menu-toggle v-model="more" />
          </template>
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

    <template v-slot:more>
      <v-switch
        v-model="item.props.contain"
        label="Contain"
        hide-details
        class="mx-3 mt-0 mb-4"
      />

      <v-switch
        v-for="option in options"
        :key="option.value"
        v-model="item.opts[option.value]"
        :label="option.text"
        class="mx-3 mt-0 mb-4"
        hide-details
      />

      <!-- <v-col class="shrink"> -->
      <adam-toggle-field v-model="item.props.align" :items="align" />
      <!-- </v-col> -->
    </template>

    <template v-slot:parent-toggle>
      <slot name="toggle" />
    </template>

    <template v-slot:parent-actions>
      <slot name="actions" />
    </template>

    <v-row>
      <v-col>
        <adam-elevation-slider v-model="item.props.elevation" />
      </v-col>
      <v-col>
        <adam-grayscale-slider v-model="item.props.grayscale" />
      </v-col>
      <v-col>
        <adam-rounded-slider v-model="item.props.rounded" />
      </v-col>
    </v-row>

    <v-slide-y-transition group>
      <adam-big-number-slider
        v-for="opt in optSliders"
        :key="`${opt.value}s`"
        v-model="item.props[opt.value]"
        :label="opt.text"
        :min="20"
        :max="1000"
        :default-value="200"
        thumb-label
        hide-details
        class="mt-4"
      />
    </v-slide-y-transition>

    <slot />
  </adam-form-layout>
</template>

<script>
import formMixin from '../mixins/form'
import linkFieldMixin from '../mixins/link-field'
import align from '../templates/text-align'
import options from '../templates/size-options'

export default {
  mixins: [formMixin, linkFieldMixin],
  data() {
    return {
      more: false,
      menu: false,
      align,
      options,
    }
  },

  computed: {
    optSliders() {
      return this.options.filter(({ value }) => this.item.opts[value])
    },
  },
}
</script>
