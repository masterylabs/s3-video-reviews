<template>
  <div>
    <v-sheet v-bind="boxAttrs">
      <v-row v-if="useHeader" no-gutters v-bind="headerAttrs">
        <div>
          <span
            :class="
              headerDiscountHighlight ? 'text-decoration-line-through' : ''
            "
            >{{ headerPriceText }} $97</span
          >
        </div>
        <div :style="`color:${headerDiscountColor}`">
          <span :class="headerDiscountHighlight ? 'ml-highlight' : ''"
            >{{ headerDiscountText }} $10.99</span
          >
        </div>
      </v-row>

      <div style="border: solid 4px red" class="rounded-none mx-4">
        <v-card v-bind="cardAttrs" @click="$emit('click')">
          <div>
            <v-row
              no-gutters
              :style="`height:${height}px;`"
              align="center"
              justify="center"
            >
              <div v-if="text" :style="`font-size:${textSize}px`">
                {{ text }}
              </div>
              <template v-else>
                <div
                  v-if="prefix"
                  class="mr-1 font-weight-medium"
                  style="margin-top:3px;"
                >
                  {{ prefix }}
                </div>

                <!-- text  -->
                <div
                  v-if="text"
                  :style="`font-size:${textSize}px;line-height:${height}px`"
                >
                  {{ text }}
                </div>

                <div
                  v-else
                  class="font-italic font-weight-bold"
                  style="font-size:20px"
                >
                  <span :style="`color:#${paypalPrimaryColor};margin-right:1px`"
                    >Pay</span
                  >
                  <span :style="`color:${paypalSecondaryColor}`">Pal</span>
                </div>
              </template>
            </v-row>
          </div>
        </v-card>
      </div>

      <div
        class="text-center mt-2 text-h5 font-weight-medium"
        style="color:#0031FD"
      >
        <u>Add To Cart</u>
      </div>

      <buy-now-button-cards :width="cardsSize" :class="`my-${cardsSpacingY}`" />
    </v-sheet>
  </div>
</template>

<script>
  import props from './props-v1'
  export default {
    props,

    computed: {
      cardAttrs() {
        let background = `radial-gradient(ellipse at bottom, rgba(255,0,0,0) 0%,rgba(255,0,0,0) 50%,rgba(255,0,0,1) 50%,rgba(255,0,0,1) 76%)`

        background = `radial-gradient(ellipse at bottom, rgba(255,210,1,1) 50%, rgba(255,60,60,1) 80%)`
        background = `radial-gradient(ellipse at bottom, #F8DB05 50%, #F87804 80%)`

        // let border = 'solid 4px #F62524'
        return {
          light: this.light,
          height: this.height,
          maxWidth: this.maxWidth,
          color: '#FBC439', // this.color,
          elevation: 1, // this.elevation,
          rounded: this.rounded,
          // class: `mx-${this.mx}`,
          tile: !this.rounded,
          style: {
            // border: 'solid 5px red',
            background,
            // border,
            // marginTop: '-8px',
          },
        }
      },

      boxAttrs() {
        if (!this.useBox)
          return {
            color: 'rgba(255,255,255,0)',
            dark: this.dark,
          }

        const boxStyle = {}
        const classList = [`mx-${this.boxMx}`]

        if (this.boxBorderWidth) {
          // boxStyle.border = `${this.boxBorderStyle} ${this.boxBorderWidth}px ${this.boxBorderColor}`
        }

        if (this.boxPadding) classList.push(`pa-${this.boxPadding}`)

        return {
          dark: this.dark,
          elevation: this.boxElevation,
          style: boxStyle,
          maxWidth: this.maxWidth,
          class: classList,
        }
      },

      headerAttrs() {
        const classList = [
          `px-${this.headerPaddingX}`,
          `py-${this.headerPaddingY}`,
          `font-weight-${this.headerDiscountFontWeight}`,
        ]

        return {
          class: classList,
          justify: this.headerJustify,
          align: this.headerAlign,
        }
      },
    },
  }
</script>
