<template>
  <div>
    <v-toolbar dense flat color="grey lighten-5" style="overflow:hidden">
      <v-switch
        v-model="item.props.contain"
        label="Contain"
        class="mr-4"
        hide-details
      />

      <v-switch
        v-for="option in options"
        :key="option.value"
        v-model="item.opts[option.value]"
        :label="option.text"
        class="mr-4"
        hide-details
      />

      <v-spacer />

      <adam-toggle-field v-model="item.props.align" :items="align" />
    </v-toolbar>

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
      />
    </v-slide-y-transition>
  </div>
</template>

<script>
  import formMixin from '../../mixins/form'
  import align from '../../templates/text-align'

  // btn
  import options from '../../templates/size-options'

  export default {
    mixins: [formMixin],
    data() {
      return {
        options,

        isColor: false,
        align,
        formatValue: [],
      }
    },

    computed: {
      optSliders() {
        return this.options.filter(({ value }) => this.item.opts[value])
      },
    },
  }
</script>
