<template>
  <div>
    <div class="title">Create Bucket In Amazon S3</div>
    <p>
      For new buckets, please first create the bucket inside your Amazon S3.
    </p>

    <v-text-field v-model="form.bucket_name" outlined label="Bucket Name" />
    <aws-region-field v-model="form.bucket_region" outlined />

    <!-- Bucket Cloudfront  -->
    <v-expand-transition>
      <v-text-field
        v-if="cloudfront"
        v-model="form.bucket_cloudfront"
        outlined
        autofocus
        label="CloudFront"
      />
    </v-expand-transition>

    <!-- Bucket Domain  -->
    <v-expand-transition>
      <v-text-field
        v-if="domain"
        v-model="form.bucket_domain"
        outlined
        autofocus
        label="Domain"
      />
    </v-expand-transition>

    <v-row no-gutters>
      <v-btn color="primary" v-bind="{ loading, disabled }" @click="submit"
        >Continue</v-btn
      >
      <v-spacer />
      <v-btn class="mx-2" depressed @click="cloudfront = !cloudfront">
        <v-icon class="mr-1">mdi-plus</v-icon>
        CloudFront
      </v-btn>
      <v-btn class="mx-2" depressed @click="domain = !domain">
        <v-icon class="mr-1">mdi-plus</v-icon>
        Domain
      </v-btn>
      <aws-buckets-icon-link :icon="false" depressed>
        Amazon S3
        <v-icon class="ml-1" small>mdi-open-in-new</v-icon>
      </aws-buckets-icon-link>
    </v-row>

    <!-- <m-code>
      {{ form }}
    </m-code> -->
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      loading: false,
      cloudfront: false,
      domain: false,
    }
  },

  computed: {
    ...mapGetters({
      form: 'addOffer/form',
      stepper: 'addOffer/stepper',
    }),
    disabled() {
      return !this.form.bucket_name || !this.form.bucket_region
    },
  },

  methods: {
    async submit() {
      this.loading = true
      const res = await this.$app.get('pages/name-exists', {
        bucket_name: this.form.bucket_name,
      })

      if (res.exists) {
        this.loading = false
        return this.$app.error('Bucket is already an offer')
      }

      this.stepper.value++
      this.loading = false
    },
  },
}
</script>
