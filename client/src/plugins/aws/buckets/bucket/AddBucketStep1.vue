<template>
  <div>
    <v-text-field
      v-model="form.name"
      outlined
      autofocus
      label="Bucket Name"
      placeholder="my-bucket-name"
    ></v-text-field>

    <aws-region-field v-model="form.region" outlined />

    <v-row no-gutters>
      <v-btn
        color="primary"
        :disabled="!canContinue"
        :loading="loading"
        @click="next"
      >
        Continue
      </v-btn>

      <v-spacer />
      <aws-buckets-icon-link :icon="false" depressed>
        Amazon S3
        <v-icon class="ml-1" small>mdi-open-in-new</v-icon>
      </aws-buckets-icon-link>
    </v-row>
  </div>
</template>

<script>
import mixin from './mixins'
export default {
  mixins: [mixin],
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    canContinue() {
      return this.form.name && this.form.region
    },
  },

  methods: {
    async next() {
      this.loading = true

      const { pagin } = await this.$app.get('/buckets', {
        name: this.form.name,
      })

      if (pagin.total > 0) {
        this.loading = false
        return this.$app.error('This bucket has already been added')
      }

      this.data.step = 2
      this.loading = false
    },
  },
}
</script>
