<template>
  <div>
    <v-expand-transition>
      <div v-if="show" class="mt-2x mb-4 mx-n4">
        <div v-if="label" class="text-center caption grey lighten-4 mx-4">
          {{ label }}
        </div>
        <v-toolbar dense flat :height="height">
          <v-row no-gutters class="mx-n4x py-0">
            <v-col v-for="color in baseColors" :key="color">
              <v-tooltip top :open-delay="tooltipOpenDelay">
                <template v-slot:activator="{ attrs, on }">
                  <v-sheet
                    v-bind="attrs"
                    v-on="on"
                    :color="color"
                    :dark="darkBaseColors[color] ? false : true"
                    @click="onBase(color)"
                    width="100%"
                    :height="height"
                    class="ml-pointer text-center"
                  >
                    <v-expand-transition>
                      <v-icon
                        v-if="baseValue === color"
                        :size="height - 10"
                        class="mt-1"
                      >
                        mdi-arrow-down
                      </v-icon>
                    </v-expand-transition>
                  </v-sheet>
                </template>
                <span class="text-capitalize">{{ color | colorName }}</span>
              </v-tooltip>
            </v-col>
            <v-col v-for="custom in customBaseColors" :key="custom.value">
              <v-tooltip top :open-delay="tooltipOpenDelay">
                <template v-slot:activator="{ attrs, on }">
                  <v-sheet
                    v-bind="attrs"
                    v-on="on"
                    width="100%"
                    :height="height"
                    :color="custom.value"
                    :dark="custom.dark"
                    class="ml-pointer text-center"
                    @click="onCustomBase(custom.value)"
                  >
                    <v-fade-transition>
                      <v-icon
                        v-if="baseValue === custom.value"
                        :size="height - 10"
                        class="mt-1"
                      >
                        mdi-check
                      </v-icon>
                    </v-fade-transition>
                  </v-sheet>
                </template>
                <span v-text="custom.text"></span>
              </v-tooltip>
            </v-col>
          </v-row>
        </v-toolbar>

        <v-expand-transition>
          <v-toolbar v-if="items" dense flat :height="height">
            <v-row no-gutters class="mx-n4x py-0">
              <v-col v-for="item in items" :key="item.hex">
                <v-tooltip bottom :open-delay="tooltipOpenDelay">
                  <template v-slot:activator="{ attrs, on }">
                    <v-sheet
                      v-bind="attrs"
                      v-on="on"
                      :color="item.hex"
                      @click="onColor(item.hex)"
                      width="100%"
                      :height="height"
                      :dark="item.dark"
                      class="ml-pointer text-center"
                    >
                      <v-fade-transition>
                        <v-icon
                          v-if="colorValue === item.hex"
                          :size="height - 10"
                          class="mt-1"
                        >
                          mdi-check
                        </v-icon>
                      </v-fade-transition>
                    </v-sheet>
                  </template>
                  <span class="text-capitalize">
                    <template v-if="customColorLabels[item.variant]">
                      {{ customColorLabels[item.variant] }}
                    </template>
                    <template v-else>
                      {{ baseValue | colorName }}
                      {{ item.variant | colorName }}
                    </template>
                  </span>
                </v-tooltip>
              </v-col>
            </v-row>
          </v-toolbar>
        </v-expand-transition>
      </div>
    </v-expand-transition>

    <v-expand-transition>
      <div class="grey lighten-5 px-3 py-4 mt-n4" v-if="opacity && colorValue">
        <v-slider
          v-model="opacityValue"
          v-on="{ input }"
          label="Opacity"
          hide-details
        >
          <template v-slot:append>
            <span class="primary--text mt-1">{{ opacityValue }}%</span>
          </template>
        </v-slider>
      </div>
    </v-expand-transition>
  </div>
</template>

<script>
import colors from '../templates/colors'
import { rgbaToHex, hexToRgb, isDark } from '../helpers/color'

export default {
  props: {
    opacity: Boolean,
    show: {
      type: Boolean,
      default: true,
    },
    label: {
      type: String,
      default: '',
    },
    value: {
      type: String,
      default: '',
    },
    height: {
      type: [String, Number],
      default: 48,
    },
    tooltipOpenDelay: {
      type: Number,
      default: 100,
    },
  },
  data() {
    return {
      opacityValue: 100,
      // opacityValues,
      customColorLabels: {
        0: 'White',
        999: 'Black',
      },
      darkBaseColors: {
        'light-green': true,
        lime: true,
        yellow: true,
        amber: true,
      },
      baseValue: '',
      colorValue: '',
      baseColors: Object.keys(colors),
      colors,
      customBaseColors: [
        {
          text: 'White',
          value: '#ffffff',
          dark: false,
        },
        {
          text: 'Black',
          value: '#000000',
          dark: true,
        },
      ],
      // items:
    }
  },

  computed: {
    rgbaValue() {
      if (!this.colorValue) return ''

      const { r, g, b } = hexToRgb(this.colorValue)
      const o = this.opacityValue / 100

      return `rgba(${r}, ${g}, ${b}, ${o})`
    },

    rgbDark() {
      return isDark(this.rgbaValue)
    },

    rgbBackToHex() {
      if (!this.rgbaValue) return ''
      return rgbaToHex(this.rgbaValue)
    },

    items() {
      if (!this.baseValue || !colors[this.baseValue]) return null

      const items = []

      const group = colors[this.baseValue]

      for (const k in group) {
        items.push({
          variant: k,
          hex: group[k],
          dark: isDark(group[k]),
        })
      }

      return items
    },
  },

  methods: {
    input() {
      const color = !this.colorValue
        ? ''
        : this.opacity
        ? this.rgbaValue
        : this.colorValue
      this.$emit('input', color)
    },

    onOpacity() {
      this.input()
    },

    onCustomBase(value) {
      if (this.baseValue === value) {
        this.baseValue = ''
        this.colorValue = ''
      } else {
        this.baseValue = value
        this.colorValue = value
      }

      this.input()
    },

    onColor(value) {
      if (this.colorValue === value) {
        this.colorValue = ''
      } else {
        this.colorValue = value
      }

      this.input()
    },

    onBase(value) {
      if (this.baseValue === value) {
        this.colorValue = ''
        this.baseValue = ''
      } else {
        this.baseValue = value
        this.colorValue = colors[value]['500']
      }

      this.input()
    },

    loadHex(color) {
      const customBase = this.customBaseColors.find(
        ({ value }) => value === color
      )

      if (customBase) {
        this.colorValue = ''
        this.baseValue = customBase.value
        return
      }

      for (const k in colors) {
        for (const k2 in colors[k]) {
          if (colors[k][k2] === color) {
            this.colorValue = color
            this.baseValue = k
            return
          }
        }
      }
    },

    loadRgb(rgba) {
      const hex = rgbaToHex(rgba)
      this.loadHex(hex)

      if (rgba.indexOf('rgba') === 0) {
        const alpha = parseFloat(rgba.split(',')[3])
        this.opacityValue = alpha * 100
      }
    },
  },

  mounted() {
    if (this.value) {
      if (this.value.indexOf('rgb') === 0) {
        this.loadRgb(this.value)
      } else {
        this.loadHex(this.value)
      }
    }
  },

  filters: {
    colorName(str) {
      return str.replace('-', ' ')
    },
  },
}
</script>
