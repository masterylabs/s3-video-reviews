<template>
  <div>
    <div class="title">Offer Details</div>

    <p>
      Enter your offer name and other details. You can also add or make changes
      to these later.
    </p>

    <v-row align="start" justify="start">
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="form.name"
          :label="m.lang.OFFER_FORM_NAME"
          :autofocus="!form.name"
          outlined
          hide-details
        />
      </v-col>
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="form.prod_name"
          :label="m.lang.OFFER_FORM_PROD_NAME"
          :autofocus="form.name && !form.prod_name ? true : false"
          outlined
          hide-details
        />
      </v-col>

      <v-col cols="12">
        <adam-video-field
          v-model="video.src"
          @service="onVideoService"
          @duration="onVideoDuration"
          hide-details
        />
      </v-col>
      <v-col>
        <v-textarea
          v-model="form.checkout_url"
          :label="m.lang.OFFER_FORM_CHECKOUT_URL"
          rows="1"
          auto-grow
          outlined
          hide-details
        />
      </v-col>
    </v-row>

    <v-expand-transition>
      <v-textarea
        v-if="description"
        class="mt-5"
        v-model="form.description"
        :label="m.lang.OFFER_FORM_DESC"
        rows="3"
        auto-grow
        outlined
        hide-details
      />
    </v-expand-transition>

    <adam-color-bar class="mt-6" v-model="theme.color" />

    <v-row no-gutters>
      <v-switch
        v-model="configureBucket"
        label="Configure bucket for website"
        :disabled="!canConfigureWebsite"
      />
    </v-row>

    <v-row no-gutters class="mt-8">
      <v-btn v-bind="{ disabled, loading }" color="primary" @click="submit"
        >Add Offer
      </v-btn>

      <v-btn
        :disabled="loading"
        :loading="creatingChalk"
        class="ml-2"
        depressed
        @click="createChalk"
        >Add Chalk
      </v-btn>

      <v-spacer />
      <v-btn class="mx-2" depressed @click="description = !description">
        <v-icon class="mr-1">mdi-plus</v-icon>
        Description
      </v-btn>

      <v-btn depressed @click="onBack">Back</v-btn>
    </v-row>

    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="180">
        <div class="white--text">Building your offer...</div>
      </v-progress-circular>
    </v-overlay>
  </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex'
import { findItem } from '@/adam/helpers/find'
import getImage from '@/adam/helpers/get-image'

export default {
  data() {
    return {
      loading: false,
      creatingChalk: false,
      description: false,
      configureBucket: false, // true,
      offerTemplate: {},
      overlay: false,

      video: {
        src: '',
        poster: '',
        service: '',
        duration: 0,
      },
      theme: {
        color: '',
        dark: false,
      },
      bg: {
        src: '',
        mobiSrc: '',
      },
    }
  },

  computed: {
    ...mapGetters({
      form: 'addOffer/form',
      stepper: 'addOffer/stepper',
      bucket: 'addOffer/bucket',
    }),
    disabled() {
      return (
        !this.form.bucket_name || !this.form.bucket_region || this.creatingChalk
      )
    },
    canConfigureWebsite() {
      if (!this.form.bucket_name || !this.form.bucket_region) {
        return false
      }

      return true
    },
  },
  methods: {
    ...mapMutations({
      clearForm: 'addOffer/CLEAR_FORM',
    }),
    ...mapActions({
      getBucket: 'addOffer/getBucket',
      configureBucketForWebsite: 'addOffer/configureBucketForWebsite',
      uploadBucketFiles: 'addOffer/uploadBucketFiles',
    }),
    onCreated(id) {
      if (this.video.src) {
        for (const k in this.video) {
          this.video[k] = ''
        }
      }

      this.clearForm()

      setTimeout(() => {
        this.stepper.value = 0
        this.loading = false
        this.creatingChalk = false
      }, 300)

      // if route, send to redirect route or close,
      this.$router.push({ name: 'new-offer-redirect', params: { id } })

      this.stepper.dialog = false
    },

    onBack() {
      this.stepper.value--
    },

    async submit() {
      this.loading = true
      this.overlay = true

      await this.getImage()
      await this.createOffer('offer')
      this.loading = true
      this.overlay = false
    },

    async createOffer(name) {
      const bucket = await this.getBucket()

      if (this.configureBucket) {
        await this.configureBucketForWebsite(bucket)
      }

      const offer = await this.$app.get(`/templates/${name}`)

      // set video
      if (this.video.src) {
        const video = findItem(offer.body.children, 'video', 'type')
        video.props.src = this.video.src
        video.service = this.video.service
        video.duration = this.video.duration
      }

      for (const k in this.form) {
        offer[k] = this.form[k]
      }

      // offer.theme = { ...this.theme }
      for (const k in this.theme) {
        if (this.theme[k]) {
          offer.theme[k] = this.theme[k]
        }
      }

      if (this.bg.src) {
        offer.bg.src = this.bg.src
        offer.bg.mobiSrc = this.bg.mobiSrc
      }

      // return

      const { data } = await this.$app.post('/pages', offer)

      // upload bucket files
      await this.uploadBucketFiles(data.id)

      this.onCreated(data.id)
    },

    async getImage() {
      try {
        const img = await getImage()

        if (img) {
          this.bg.src = img.src
          this.bg.mobiSrc = img.mobiSrc
        }
        return true
      } catch {
        return false
      }
    },

    async createChalk() {
      this.creatingChalk = true
      this.overlay = true

      await this.createOffer('chalk')
      this.overlay = false
    },
    onVideoDuration(value) {
      this.video.duration = value
    },

    onVideoService(value) {
      this.video.service = value
    },
  },
  mounted() {
    this.configureBucket = this.canConfigureWebsite
    // this.createOffer('offer')
  },
}
</script>
