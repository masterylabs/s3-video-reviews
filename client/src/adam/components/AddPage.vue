<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="700" persistent @input="onDialog">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" large outlined v-bind="attrs" v-on="on">
          <v-icon class="mr-1">mdi-plus</v-icon>
          Add Offer
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2 font-weight-regular mb-4">
          Add New Offer
        </v-card-title>

        <v-card-text>
          <adam-offer-form v-model="offer" is-adder>
            <template v-slot:append>
              <adam-video-field
                v-model="video.props.src"
                v-bind="{ duration: video.duration }"
                v-on="{ duration, service }"
                class="mb-3"
                @service="video.service = $event"
                @loading="videoLoading = $event"
              />
            </template>

            <template v-slot:footer>
              <v-btn
                v-bind="{ disabled, loading }"
                color="primary"
                @click="createOffer"
                >Add Offer
              </v-btn>

              <v-btn
                :disabled="loading"
                class="ml-2"
                depressed
                @click="createChalk"
                >Add Chalk
              </v-btn>
            </template>
          </adam-offer-form>
        </v-card-text>

        <v-btn icon absolute right top class="mt-n1" large @click="onClose">
          <v-icon> mdi-close </v-icon>
        </v-btn>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import getImage from '../helpers/get-image'

export default {
  data() {
    return {
      dialog: false,
      loading: false,
      videoLoading: false,

      addingChalk: false,

      testPage: null,
      imageLoaded: false,

      offer: {
        name: '', // 'New Offer',
        prod_name: '', // 'New Product',
        slug: '', // 'new-offer-' + Math.floor(Date.now() / 1000),
        description: '', // 'New offer description...',
        checkout_url: '', // 'https://google.com/?checkout',
        theme: {
          color: '#ff9800',
          dark: false,
        },
        page_type: 'offer',
        bg: {
          src: '',
          mobiSrc: '',
          filter: 'blur(1px) brightness(90%)',
        },
      },
      video: {
        props: {
          src: '', // 'http://media.test/video.mp4', // http://media.test/video.mp4
          poster: '',
        },
        duration: 0,
        service: '',
      },
    }
  },

  computed: {
    disabled() {
      return this.videoLoading || this.addingChalk || !this.offer.name
        ? true
        : false
    },
  },

  methods: {
    onClose() {
      this.dialog = false
    },

    onDialog() {
      if (!this.imageLoaded) {
        this.getImage()
      }
    },
    duration(n) {
      this.video.duration = n
    },
    service(service) {
      this.video.service = service
    },

    async createChalk() {
      this.addingChalk = true
      this.imageLoaded = false

      this.offer.bg.src = ''
      this.offer.bg.mobiSrc = ''

      const { id } = await this.$store.dispatch('adam/addOffer', {
        offer: this.offer,
        video: this.video,
        template: 'chalk',
      })

      if (id) {
        this.$router.push({ name: 'offer', params: { id } })
      }
      this.addingChalk = false
    },

    async createOffer() {
      this.loading = true
      this.imageLoaded = false
      const { id } = await this.$store.dispatch('adam/addOffer', {
        offer: this.offer,
        video: this.video,
      })

      if (id) {
        this.$router.push({ name: 'offer', params: { id } })
      }
      this.loading = false
    },

    async getImage() {
      const img = await getImage()

      if (img) {
        this.offer.bg.src = img.src
        this.offer.bg.mobiSrc = img.mobiSrc
        this.imageLoaded = true
      }
    },
  },
}
</script>
