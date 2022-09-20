<template>
  <v-main class="main-item">
    <v-container
      :fill-height="!$vuetify.breakpoint.smAndDown && theme.fillHeight"
      :fluid="theme.isFluid"
      class="main-item-container pa-0"
      :class="`my-md-${theme.myMd}`"
    >
      <v-row align="center" justify="center" no-gutters>
        <v-sheet
          v-bind="getSheet"
          class="main-item-sheet overflow-hidden"
          :class="[`pa-${theme.pa || 0}`]"
        >
          <div>
            <slot />
          </div>
        </v-sheet>
      </v-row>
      <template
        v-if="
          theme.fillHeight && theme.nudgeUp && !$vuetify.breakpoint.smAndDown
        "
      >
        <v-row v-for="n in shiftUp" :key="`shiftUp${n}`" />
      </template>
    </v-container>
  </v-main>
</template>

<script>
import sheet from '../mixins/sheet'

export default {
  mixins: [sheet],
  props: {
    fillHeight: {
      type: Boolean,
      default: true,
    },
    nudgeUp: {
      type: Boolean,
      default: false,
    },
    fluid: {
      type: Boolean,
      default: false,
    },
    shiftUp: {
      type: Number,
      default: 2,
    },
    pa: {
      type: Number,
      default: 0,
    },
    my: {
      type: Number,
      default: 0,
    },
  },

  computed: {
    // height () {
    //   switch (this.$vuetify.breakpoint.name) {
    //     case 'xs': return 220
    //     case 'sm': return 400
    //     case 'md': return 500
    //     case 'lg': return 600
    //     case 'xl': return 800
    //   }
    // },
    getSheet() {
      const isMobile = this.$vuetify.breakpoint.smAndDown
      const t = this.theme
      // const color = t.color || '' // ? t.color : t.dark ? '' : '#fff'

      const value = {
        color: t.bgColor || '',
        dark: t.dark,
        light: false,
        width: '100%',
        // rounded: 'pill',
      }

      if (t.useMaxWidth) {
        value.maxWidth = t.maxWidth
      }

      value.rounded = isMobile ? 0 : t.rounded
      value.elevation = isMobile ? 0 : t.elevation

      // value.class = 'overflow:hidden'

      return value

      // const value = {
      //   // ...this.sheet,
      //   color: this.color,
      //   dark: false,
      //   light: false,
      //   width: '100%',
      // }

      // if (this.$vuetify.breakpoint.smAndDown) {
      // //   value.my = 0
      // //   value.rounded = '0'
      // //   value.elevation = 0
      // //   // value.
      // }

      // return value
    },
  },
}
</script>
