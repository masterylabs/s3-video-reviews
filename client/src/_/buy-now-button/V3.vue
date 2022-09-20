<template>
  <div>
    <div class="title">Buy Now Buttons Version 3</div>
    <v-btn @click="makeImage">make</v-btn>

    <div id="buttonContainer" ref="buttonContainer" style="width: 400px">
      <v-card>
        <v-row no-gutters justify="space-between" class="px-3">
          <v-col class="text-left">
            <s>Regular Price $97</s>
          </v-col>
          <v-col class="text-right"> Special Price $47 </v-col>
        </v-row>

        <v-card>
          <div
            style="
              font-family: verdana;
              background: yellow;
              border: dashed 2px red;
            "
          >
            Button Conext
          </div>
        </v-card>
      </v-card>
    </div>

    <v-row ref="buttons" id="buttons" no-gutters></v-row>
  </div>
</template>

<script>
// import { toPng } from 'html-to-image'
export default {
  methods: {
    makeImage() {
      const node = document.querySelector('#buttonContainer') // this.$refs.buttonContainer

      // toPng(node)
      //   .then((dataUrl) => {
      //     var img = new Image()
      //     img.src = dataUrl
      //     this.$refs.buttons.appendChild(img)
      //   })
      //   .catch(function() {})
    },
  },
}
</script>
