<template>
  <div>
    <adam-padding-form :id="id" />

    <adam-margin-form :id="id" />
    <!-- <v-divider class="mb-4" /> -->

    <v-row>
      <v-col cols="6">
        <adam-rounded-slider v-model="item.props.rounded" />
      </v-col>
      <v-col>
        <v-slider
          v-model="item.props.elevation"
          label="Shadow"
          max="16"
        ></v-slider>
      </v-col>
    </v-row>

    <v-slide-y-transition group>
      <adam-big-number-slider
        v-for="opt in optSliders"
        :key="`${opt.value}s`"
        v-model="item.props[opt.value]"
        :label="opt.text"
        :min="opt.min"
        :max="opt.max"
        thumb-label
      />
    </v-slide-y-transition>

    <slot name="append" />

    <v-row no-gutters align="center" justify="start" class="mx-n2">
      <v-switch
        v-for="opt in options"
        :key="opt.value"
        v-model="item.opts[opt.value]"
        :label="opt.text"
        class="mx-2"
      />
      <slot name="options-append" />

      <!-- <slot name="options-prepend" /> -->
      <v-switch
        v-if="!noDark"
        v-model="item.props.dark"
        :disabled="item.props.light"
        label="Dark"
        class="mx-2"
      />
      <v-switch
        v-if="!noLight"
        v-model="item.props.light"
        :disabled="item.props.dark"
        label="Light"
        class="mx-2"
      />

      <v-spacer />

      <adam-color-toggle
        v-model="color"
        :color="item.props.color"
        class="mx-2"
        bg
      />

      <v-btn depressed class="mx-2" @click="resetSpacing">
        Reset Spacing
      </v-btn>
    </v-row>

    <v-expand-transition>
      <adam-color-bar v-show="color" v-model="item.props.color" opacity />
    </v-expand-transition>
  </div>
</template>

<script>
  import formMixin from '../mixins/form'
  import options from '../templates/size-options'
  export default {
    props: {
      noDark: Boolean,
      noLight: Boolean,
    },

    mixins: [formMixin],
    data() {
      return {
        show: false,
        color: false,
        options,
      }
    },

    computed: {
      optSliders() {
        return this.options.filter(({ value }) => this.item.opts[value])
      },
    },

    methods: {
      resetSpacing() {
        const keys = [
          //
          'pl',
          'pr',
          'pt',
          'pb',
          'ml',
          'mr',
          'mt',
          'mb',
        ]

        keys.forEach((key) => {
          if (this.item.props[key]) {
            this.item.props[key] = 0
          }
        })
      },
    },
  }
</script>
