<template>
  <v-card min-height="200" flat>
    <!-- <v-system-bar v-if="!noBar" dark color="secondary">
      <span v-if="!noTitle">{{ title }}</span>
      <v-spacer></v-spacer>
      <v-icon
        v-for="color in bgColors"
        :key="color"
        icon
        small
        v-bind="{ color }"
        @click="onBgColor(color)"
      >
        mdi-circle
      </v-icon>
    </v-system-bar> -->

    <v-row
      class="text-center image-container text-center pa-3"
      :class="bgColor"
      style="min-height: 200px"
      align="center"
      justify="center"
      no-gutters
    >
      <img
        v-if="image.url"
        ref="image"
        :src="image.url"
        style="max-width: 100%"
        @load="onImageLoad"
      />
      <m-loading-circle v-else />
    </v-row>
    <!-- 
    <v-sheet
      min-height="200"
      ref="imageContainer"
      class="image-container text-center mb-6 pa-3"
      :class="bgColor"
    >
      <img
        v-if="image.url"
        ref="image"
        :src="image.url"
        style="max-width: 100%"
        @load="onImageLoad"
      />

      <m-loading-circle v-if="!isReady" />
      <v-progress-circular
        v-if="!isReady"
        class="image-loading"
        indeterminate
        size="90"
        color="grey lighten-2"
      />
    </v-sheet> -->

    <v-expand-transition>
      <v-card-text v-if="isReady" class="py-8">
        <stats-row>
          <stats-item name="width">
            {{ source.width }}
          </stats-item>
          <stats-item name="height">
            {{ source.height }}
          </stats-item>
          <v-divider vertical class="mx-2"></v-divider>
          <stats-item name="original size">
            {{ source.size | bytes }}
          </stats-item>
          <stats-item name="compressed size">
            {{ image.size | bytes }}
          </stats-item>
          <v-divider vertical class="mx-2"></v-divider>
          <stats-item name="improvement" :class="`${improveColor}--text`">
            {{ sizeImprovement }}%
          </stats-item>
        </stats-row>

        <v-row align="center">
          <v-col class="shrink">
            <v-select
              v-model="format"
              label="Format"
              :items="formatItems"
              :disabled="!isReady || isLoading"
              style="width: 160px"
              @change="changeFormat"
            ></v-select>
          </v-col>
          <v-col>
            <v-slider
              label="Compress Image"
              max="40"
              v-model="compressValue"
              v-on="{ input }"
              :disabled="!canSlideCompress"
              hide-details
            />
          </v-col>
          <v-col class="shrink">
            <m-tooltip value="Resize options">
              <v-btn icon class="mt-n2" @click="more = !more">
                <v-icon>mdi-chevron-{{ more ? 'up' : 'down' }}</v-icon>
              </v-btn></m-tooltip
            >
          </v-col>
        </v-row>

        <v-expand-transition>
          <v-row v-if="more">
            <v-col>
              <v-select
                label="Resize"
                v-model="form.resize"
                :items="resizeItems"
                outlined
                hide-details
                @input="onForm"
              ></v-select>
            </v-col>
            <v-col v-for="v in sizes" :key="v.value">
              <v-text-field
                v-model="form[v.value]"
                :label="v.text"
                type="number"
                min="0"
                clearable
                outlined
                hide-details
                @input="onForm"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-expand-transition>
      </v-card-text>
    </v-expand-transition>

    <!-- <v-btn @click="convertToJpg">Convert TO JPG</v-btn> -->
    <!-- <div ref="dev"></div> -->
  </v-card>
</template>

<script>
// import Compressor from 'compressorjs'
import prettyBytes from 'pretty-bytes'
// import convertMixin from './mixins/convert'
// import loadImage from './mixins/load-image'
import events from './Events'
import methods from './Methods'

import statsRow from './components/StatsRow.vue'
import statsItem from './components/StatsItem.vue'
export default {
  components: {
    statsRow,
    statsItem,
  },

  props: {
    noBar: Boolean,
    noTitle: Boolean,
    ready: {
      type: Boolean,
      default: true,
    },
    url: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: '',
    },
    fileName: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isReady: false,
      isLoading: false,
      compressor: null,
      more: false,
      compressValue: 0,
      minContainerHeight: 0,
      result: null,
      source: {
        size: 0,
        type: '',
        file: null,
        width: 0,
        height: 0,
      },
      image: {
        size: 0,
        type: '',
        image: null,
        url: '',
        width: 0,
        height: 0,
      },
      format: '',
      originalFormat: '',
      form: {
        quality: 0.8,
        maxWidth: undefined,
        maxHeight: undefined,
        width: undefined,
        weight: undefined,
        resize: 'none',
      },
      resizeItems: ['none', 'contain', 'cover'],
      formatItems: [
        {
          text: 'JPG',
          value: 'image/jpeg',
        },
        {
          text: 'PNG',
          value: 'image/png',
        },
        {
          text: 'GIF',
          value: 'image/gif',
        },
        {
          text: 'WebP',
          value: 'image/webp',
        },
      ],
      sizes: [
        {
          text: 'Width',
          value: 'width',
        },
        {
          text: 'Height',
          value: 'height',
        },
        {
          text: 'Max Width',
          value: 'maxWidth',
        },
        {
          text: 'Max Height',
          value: 'maxHeight',
        },
      ],
      bgColors: ['white', 'grey lighten-3', 'black'],
      bgColor: 'grey lighten-3',
    }
  },

  computed: {
    sizeImprovement() {
      if (!this.image.size) {
        return 0
      }
      const diff = this.source.size - this.image.size
      let value = Math.floor((diff / this.source.size) * 100)
      return value // value > 0 ? value : 0
    },
    improveColor() {
      if (!this.sizeImprovement || this.sizeImprovement < 0) {
        return ''
      }

      if (this.form.quality < 0.15) {
        return 'error'
      }

      if (this.form.quality < 0.31) {
        return 'warning'
      }
      return 'success'
    },

    canSlideCompress() {
      if (!this.format) {
        return false
      }
      const type = this.format.split('/').pop().toLowerCase()

      return ['jpg', 'jpeg'].includes(type)
    },
  },

  methods: {
    ...events,
    ...methods,
  },

  mounted() {
    // return
    if (this.url) {
      this.loadImage()
    } else {
      this.$watch('url', () => {
        this.loadImage()
      })
    }
  },

  filters: {
    bytes(n) {
      return prettyBytes(n)
    },
  },
}
</script>
<style scoped>
img {
  vertical-align: bottom;
}
.image-container {
  position: relative;
}
.image-bg-tools {
  position: absolute;
  right: 20px;
  bottom: 20px;
}
</style>
