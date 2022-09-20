<template>
  <div>
    <v-row align="center" class="mb-3">
      <v-col
        v-for="(slider, i) in sliders"
        :key="`slider${i}`"
        cols="12"
        :md="i < 3 ? 4 : 6"
        :lg="i < 3 ? 2 : 3"
      >
        <v-slider
          v-if="slider.value === 'mainSection_mb'"
          v-model="mainSection.childProps.mb"
          :label="slider.text"
          min="0"
          max="16"
          hide-details
        >
          <template v-slot:append>
            <span class="primary--text pt-1">
              {{ mainSection.childProps.mb }}
            </span>
          </template>
        </v-slider>

        <component
          v-else-if="slider.component"
          :is="`adam-${slider.component}-slider`"
          v-model="item.props[slider.value]"
          hide-details
        />

        <v-slider
          v-else
          v-model="item.props[slider.value]"
          :label="slider.text"
          :max="slider.max || 16"
          hide-details
        >
          <template v-slot:append>
            <span class="primary--text pt-1">
              {{ item.props[slider.value] }}
            </span>
          </template>
        </v-slider>
      </v-col>
    </v-row>

    <v-expand-transition>
      <adam-big-number-slider
        v-if="item.opts.maxWidth"
        v-model="item.props.maxWidth"
        label="Max Width"
      />
    </v-expand-transition>

    <v-row align="center" class="my-0">
      <v-switch
        v-for="opt in options"
        :key="opt.value"
        v-model="item[opt.key || 'props'][opt.value]"
        class="mx-3 mt-0"
        :label="opt.text"
        :disabled="disabled[opt.value]"
      />

      <!-- move to main  -->
      <v-switch
        v-if="darkAccess"
        v-model="item.dark"
        color="black"
        label="Dark Theme"
        class="ml-4 mt-n1"
        hide-details
      />

      <v-spacer />
      <v-col class="shrink pr-4">
        <adam-color-toggle
          v-model="color"
          :color="item.props.color"
          class="mr-2"
          bg
          tooltip="Content Background"
        />
      </v-col>
    </v-row>

    <v-expand-transition>
      <adam-color-bar
        v-show="color"
        v-model="item.props.color"
        label="Content Background"
        opacity
      />
    </v-expand-transition>

    <!-- <dev-raw :value="mainSection.childProps" /> -->
  </div>
</template>

<script>
import accessMixin from '@/mixins/access'
import { findItem } from '../helpers/find'
export default {
  mixins: [accessMixin],
  data() {
    return {
      color: false,
      options: [
        {
          text: 'Max Width',
          value: 'maxWidth',
          key: 'opts',
        },
        {
          text: 'Fluid',
          value: 'fluid',
        },
        {
          text: 'V-Center',
          value: 'fillHeight',
        },
        {
          text: 'Nudge Up',
          value: 'nudgeUp',
          requires: 'fillHeight',
        },
      ],
      sliders: [
        {
          text: 'Padding',
          value: 'pa',
          max: 16,
        },
        {
          text: 'Margin',
          value: 'my',
          max: 16,
        },
        {
          text: 'Spacing',
          value: 'mainSection_mb',
          max: 16,
          mainSection: true,
        },
        {
          value: 'rounded',
          component: 'rounded',
        },
        {
          text: 'Shadow',
          value: 'elevation',
          max: 16,
        },
      ],
    }
  },

  computed: {
    item: {
      get() {
        return findItem(this.$store.getters['adam/page'].body, 'main', 'type')
      },
    },

    mainSection() {
      return this.item.children[0]
    },

    disabled() {
      return {
        nudgeUp: !this.item.props.fillHeight,
      }
    },
  },

  created() {
    if (!this.mainSection.childProps) {
      this.mainSection.childProps = {
        mb: 0,
      }
    }
  },
}
</script>
