<template>
  <div>
    <v-row align="center" class="mb-3">
      <v-col
        cols="12"
        :md="slider.cols || 4"
        v-for="slider in sliderItems"
        :key="slider.value"
      >
        <component
          v-if="slider.component"
          :is="`adam-${slider.component}-slider`"
          v-model="page.theme[slider.value]"
          :label="slider.text"
          hide-details
        />
        <m-tooltip v-else :value="slider.tip">
          <v-slider
            v-model="page.theme[slider.value]"
            :label="slider.text"
            show-thumb="always"
            :max="slider.max || 16"
            hide-details
          >
            <template v-slot:append>
              <span class="primary--text pt-1">
                {{ page.theme[slider.value] }}
              </span>
            </template>
          </v-slider>
        </m-tooltip>
      </v-col>
    </v-row>

    <v-expand-transition>
      <adam-big-number-slider
        v-if="page.theme.useMaxWidth"
        v-model="page.theme.maxWidth"
        label="Max Width"
      />
    </v-expand-transition>

    <adam-color-bar
      v-model="page.theme.color"
      label="Theme Color"
      class="mb-8"
    />

    <v-expand-transition>
      <adam-color-bar
        v-show="color"
        v-model="page.theme.bgColor"
        label="Content Background"
        opacity
      />
    </v-expand-transition>

    <v-row align="center" class="mb-2">
      <v-switch
        v-for="opt in options"
        :key="opt.value"
        v-model="page.theme[opt.value]"
        class="mx-3 mt-n1"
        hide-details
        :label="opt.text"
        :disabled="disabled[opt.value]"
      />

      <!-- move to main 
        v-if="!darkAccess"  -->
      <v-switch
        v-if="darkAccess"
        v-model="page.theme.dark"
        color="black"
        label="Dark Theme"
        class="mx-3 mt-n1"
        hide-details
      />

      <v-spacer />
      <v-col class="shrink pr-4">
        <adam-color-toggle
          v-model="color"
          :color="page.theme.contentBgColor"
          class="mr-2"
          bg
          tooltip="Content Background"
        />
      </v-col>
    </v-row>

    <!-- <dev-raw :value="mainSection.childProps" /> -->
    <!-- <m-code>
      {{ page.theme }}
    </m-code> -->
  </div>
</template>

<script>
import accessMixin from '@/mixins/access'
import { findItem } from '../helpers/find'
import { mapGetters } from 'vuex'
export default {
  mixins: [accessMixin],
  data() {
    return {
      color: false,
      options: [
        {
          text: 'Max Width',
          value: 'useMaxWidth',
          key: 'opts',
        },
        {
          text: 'Fluid',
          value: 'isFluid',
        },
        // {
        //   text: 'Hide Overflow',
        //   value: 'hideOverflow',
        // },
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
      sliderItems: [
        {
          text: 'Page Margin',
          value: 'myMd',
          tip: 'Page outer margin (top and bottom on desktop)',
          // cols: 6,
        },
        {
          text: 'Page Padding',
          value: 'pa',
          tip: 'Page inner padding',
          max: 8,
          // cols: 6,
        },
        {
          text: 'Block Padding',
          value: 'blockPadding',
          tip: 'Content block inner padding',
          max: 8,
        },
        // {
        //   text: 'Box Padding',
        //   value: 'boxPadding',
        //   tip: 'Content box inner padding',
        // },
        {
          text: 'Block Spacing',
          value: 'spaceY',
          max: 7,
          tip: 'Space out content blocks',
        },
        {
          text: 'Item Padding',
          value: 'boxPaddingY',
          tip: 'Item inner padding',
          max: 8,
        },
        {
          text: 'Item Spacing',
          value: 'boxSpaceY',
          tip: 'Item vertical spacing',
          max: 7,
        },
        {
          text: 'Rounded',
          value: 'rounded',
          tip: 'Page border radius',
          component: 'rounded',
          cols: 6,
        },
        {
          text: 'Shadow',
          value: 'elevation',
          max: 16,
          cols: 6,
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      page: 'adam/page',
    }),

    disabled() {
      return {
        nudgeUp: !this.page.theme.fillHeight,
      }
    },
  },

  // created() {
  //   if (!this.mainSection.childProps) {
  //     this.mainSection.childProps = {
  //       mb: 0,
  //     }
  //   }
  // },
}
</script>
