<template>
  <div>
    <v-row>
      <v-col cols="12" :sm="isOto ? 4 : 6">
        <v-text-field
          v-model="form.name"
          :label="isOffer ? m.lang.OFFER_FORM_NAME : m.lang.PAGE_FORM_NAME"
          :autofocus="!form.name"
          outlined
        />
      </v-col>
      <v-col v-if="isOffer || isOto" cols="12" :sm="isOto ? 4 : 6">
        <v-text-field
          v-model="form.prod_name"
          :label="m.lang.OFFER_FORM_PROD_NAME"
          :autofocus="form.name && !form.prod_name ? true : false"
          outlined
        />
      </v-col>
      <v-col v-if="!isOffer" cols="12" :sm="isOto ? 4 : 6">
        <adam-file-name-field v-model="form.slug" />
      </v-col>
    </v-row>

    <v-textarea
      v-model="form.description"
      :label="m.lang.OFFER_FORM_DESC"
      placeholder="For your reference"
      rows="3"
      outlined
    />

    <v-textarea
      v-if="!isThanks && !isLegal"
      v-model="form.checkout_url"
      :label="m.lang.OFFER_FORM_CHECKOUT_URL"
      rows="1"
      auto-grow
      outlined
    />

    <v-row>
      <v-col cols="12" :sm="isOffer ? 6 : 12">
        <m-wp-media
          v-model="form.admin_image"
          label="Admin Cover Image"
          outlined
          hide-details
        />
      </v-col>
      <v-col v-if="isOffer" cols="12" sm="6">
        <v-text-field
          v-model="form.favicon"
          label="Favicon"
          outlined
          hide-details
        >
          <template v-slot:append>
            <adam-media v-model="form.favicon" />
          </template>
        </v-text-field>
      </v-col>
    </v-row>

    <v-row v-if="isOffer">
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="form.bucket_domain"
          label="Custom Domain"
          outlined
          hide-details
        />
      </v-col>
      <v-col cols="12" sm="6">
        <adam-cloud-front-field v-model="form.bucket_cloudfront" hide-details />
      </v-col>
      <v-col cols="12" sm="6">
        <v-text-field
          :value="form.bucket_name"
          label="Bucket Name"
          outlined
          readonly
          disabled
          append-icon="mdi-lock"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6">
        <v-text-field
          :value="form.bucket_region"
          label="Bucket Region"
          outlined
          disabled
          readonly
          append-icon="mdi-lock"
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row v-if="isOffer" no-gutters justify="end" class="mt-5">
      <adam-rebuild-bucket-btn />
    </v-row>
    <div v-else class="py-2"></div>
  </div>
</template>

<script>
import accessMixin from '@/mixins/access'
import { mapGetters } from 'vuex'
export default {
  mixins: [accessMixin],
  props: {
    isAdder: Boolean,
    value: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      more: false,
      color: false,
      model: null,
    }
  },

  computed: {
    ...mapGetters({
      page: 'adam/page',
    }),
    form() {
      return this.model ? this.model : this.$store.getters['adam/page']
    },
    isOffer() {
      return this.form.page_type === 'offer'
    },
    isThanks() {
      return this.form.page_type === 'thanks'
    },
    isOto() {
      return this.form.page_type === 'oto'
    },
    isLegal() {
      return this.form.page_type === 'legal'
    },
  },

  beforeMount() {
    // conditional watcher
    if (this.value) {
      this.model = { ...this.value }

      this.$watch('form', {
        handler() {
          this.$emit('input', { ...this.form })
        },
        deep: true,
      })
    }
  },
}
</script>
