<template>
  <div>
    <div ref="BuyNowButton" style="width: 400px" :class="`pt-${spacingY}`">
      <!-- header -->
      <buy-now-button-headline :class="`mb-${spacingY}`">
        Claim Your Copy Now!
      </buy-now-button-headline>

      <v-card
        class="pa-1"
        flat
        color="rgba(0,0,0,0)"
        :style="`background-image: url(${dashedBackground('red')})`"
      >
        <v-card flat colorx="rgba(255,255,255,0)" :class="`pt-${spacingY}`">
          <div :class="`py-${boxPaddingY} px-${boxPaddingX}`">
            <v-row
              v-if="useHeader"
              no-gutters
              justify="space-around"
              :class="`mb-${spacingY}`"
              class="font-weight-medium text-center"
              :style="`font-size:${17}px`"
            >
              <v-col>
                <s>Normal Price $597</s>
              </v-col>
              <v-col>
                <span class="ml-highlight">Today Only $99</span>
              </v-col>
            </v-row>

            <!-- Button  -->
            <v-card
              max-width="340"
              flat
              tile
              color="red"
              class="mx-auto pa-1"
              :class="`mb-${spacingY}`"
            >
              <v-card
                color="#FBC439"
                :style="buttonStyle"
                elevation="3"
                @click="$emit('click')"
              >
                <v-row
                  no-gutters
                  align="center"
                  justify="center"
                  style="height: 45px"
                >
                  <v-col class="text-center">
                    <v-icon class="mt-n3">mdi-cart</v-icon>
                    <span
                      style="font-size: 30px; color: #010044; font-weight: 500"
                    >
                      Add To Cart
                    </span>
                  </v-col>
                </v-row>
              </v-card>
            </v-card>

            <!-- Below -->
            <div
              class="text-center text-decoration-underline text-h5"
              :class="`mb-${spacingY}`"
            >
              Add To Cart
            </div>
            <div class="text-center" :class="`pb-${spacingY}`">
              <buy-now-button-cards width="28" />
            </div>

            <div class="text-center" :class="`pb-${spacingY}`">Footer Text</div>
          </div>
        </v-card>
      </v-card>
    </div>
    <v-btn @click="makeImage">Save Image</v-btn>

    <div ref="buttons" class="pa-12"></div>
  </div>
</template>

<script>
const dashedBackground = (color = '#ffff00') => {
  return `"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='${color}' stroke-width='8' stroke-dasharray='11%2c 18' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e"`
}
// import { toPng } from 'html-to-image'

export default {
  props: {
    useRegularPrice: Boolean,
    useSpecialPrice: Boolean,
    spacingY: {
      type: [String, Number],
      default: 1,
    },
    boxPaddingY: {
      type: [String, Number],
      default: 3,
    },
    boxPaddingX: {
      type: [String, Number],
      default: 2,
    },
  },

  data() {
    return {
      dashedBackground,
    }
  },

  computed: {
    useHeader() {
      return this.useRegularPrice || this.useSpecialPrice ? true : false
    },
    buttonStyle() {
      let background = `radial-gradient(ellipse at bottom, #F8DB05 50%, #F87804 80%)`
      background = `radial-gradient(ellipse at bottom, #FACC0B 65%, #F99B21 75%)`
      background = `radial-gradient(ellipse at bottom, #FACC0B 60%, #FF8D00 75%)`

      return {
        background,
      }
    },
  },

  methods: {
    makeImage() {
      const node = this.$refs.BuyNowButton

      // toPng(node)
      //   .then((dataUrl) => {
      //     var img = new Image()
      //     img.src = dataUrl
      //     this.$refs.buttons.appendChild(img)
      //   })
      //   .catch(function(error) {
      //     console.error('oops, something went wrong!', error)
      //   })
    },
  },
}
</script>
