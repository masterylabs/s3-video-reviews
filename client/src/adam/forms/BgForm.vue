<template>
  <div>
    <v-row align="center" class="mb-4">
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="bg.src"
          :label="m.lang.OFFER_BG_IMG"
          @input="loadImage"
          outlined
          hide-details
        >
          <template v-slot:append>
            <adam-media v-model="bg.src" />
          </template>
        </v-text-field>
      </v-col>
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="bg.mobiSrc"
          :label="m.lang.OFFER_BG_IMG_MOBI"
          append
          outlined
          hide-details
          @input="loadImage"
        >
          <template v-slot:append>
            <adam-media v-model="bg.mobiSrc" />

            <v-btn
              icon
              class="ml-1"
              :disabled="!bg.mobiSrc"
              @click="onMobiPreview"
            >
              <v-icon
                v-text="`mdi-eye${!bgImage.previewMobi ? '-off' : ''}`"
              ></v-icon>
            </v-btn>
            <v-btn
              icon
              class="ml-2"
              :disabled="!bgImage.previewMobi"
              @click="onMobilLandscape"
            >
              <v-icon>mdi-phone-rotate-landscape</v-icon>
            </v-btn>
          </template>
        </v-text-field>
      </v-col>
    </v-row>
    <v-expand-transition>
      <m-css-filter-field
        v-if="showFilters"
        v-model="bg.filter"
        :disabled="!bg.src && !bg.mobiSrc"
        @input="loadImage"
      />
    </v-expand-transition>

    <adam-color-bar v-model="bg.color" class="mt-2" />

    <!-- {{ bg.color }} -->
  </div>
</template>

<script>
import bgImageMixin from '@/mixins/bg-image'
import { mapGetters } from 'vuex'
export default {
  mixins: [bgImageMixin],

  props: {
    fxAccess: Boolean,
    active: Boolean,
  },

  computed: {
    ...mapGetters({
      bgImage: 'layout/bgImage',
    }),

    showFilters() {
      return this.bg.src || this.bg.mobiSrc ? true : false
    },
    bg: {
      get() {
        return this.$store.getters['adam/page'].bg
      },
      set(bg) {
        this.$store.commit('adam/SET_PAGE_PROP', { bg })
      },
    },

    slugUrl() {
      if (this.value) return 'slug/0'

      return this.$store.getters['admin/slugUrl']
    },
  },

  methods: {
    loadImage() {
      const img = { ...this.bgImage, ...this.bg }

      this.setBgImage(img)
    },
    onMobiPreview() {
      this.bgImage.previewMobi = !this.bgImage.previewMobi
      this.loadImage()
    },
    onMobilLandscape() {
      this.bgImage.mobiLandscape = !this.bgImage.mobiLandscape
      this.loadImage()
    },

    onMediaSelect(value) {},
  },

  watch: {
    active(v) {
      if (v) {
        this.loadImage()
      } else {
        this.clearBgImage()
      }
    },
  },

  created() {
    if (!this.bg) {
      this.bg = {
        src: '',
        mobileSrc: '',
        filter: '',
      }
    }
  },
}
</script>
