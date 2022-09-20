<template>
  <div>
    <v-text-field
      ref="name"
      v-model="form.name"
      label="Bucket Name"
      placeholder="same-as-on-amazon-aws"
    />
    <aws-region-field v-model="form.region" @input="onRegion" />

    <v-expand-transition>
      <div v-if="moreOptions" class="mt-n3">
        <v-text-field
          v-model="form.meta.displayName"
          label="Display Name"
          :placeholder="form.name"
        ></v-text-field>

        <aws-buckets-color-field v-model="form.meta.color" />
        <aws-buckets-icon-field v-model="form.meta.icon" class="mb-5" />
      </div>
    </v-expand-transition>

    <v-row no-gutters align="start" class="mt-2">
      <v-btn
        v-bind="{ loading }"
        :disabled="!form.name"
        @click="submit"
        color="primary"
      >
        Add Now
      </v-btn>
      <v-spacer />

      <v-btn depressed small @click="moreOptions = !moreOptions">
        More Options
      </v-btn>
    </v-row>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import { slugify } from '../helpers'
export default {
  data() {
    return {
      loading: false,
      moreOptions: false,
      form: {
        name: '',
        region: 'us-east-1',
        meta: {
          color: '#607D8B',
          icon: 'bucket',
        },
      },
    }
  },

  computed: {
    ...mapGetters({
      auth: 'aws/auth',
      layout: 'awsBuckets/layout',
    }),
  },

  methods: {
    ...mapActions({
      getBucket: 'aws/getBucket',
      clearItem: 'awsBuckets/clearItem',
      loadItem: 'awsBuckets/loadItem',
    }),

    onRegion(value) {
      this.$localforage.setItem('region', value)
    },
    async submit() {
      this.loading = true

      const onError = (msg) => {
        this.loading = false
        this.$app.error(msg)
      }

      // slugify name
      const name = slugify(this.form.name)
      const { pagin } = await this.$app.get('/buckets', { name })

      if (pagin.total > 0) {
        this.loading = false
        this.$refs.name.focus()
        return onError('Bucket already has been added')
      }

      const bucket = await this.getBucket(this.form.name)

      if (!bucket) {
        return onError('Unable to locate bucket in your Amazon AWS')
      }

      if (bucket) {
        const { data } = await this.$app.post('/buckets', this.form)
        this.layout.addBucketDialog = false
        this.clearItem()
        if (this.$route.name === 'aws-bucket') {
          this.loadItem(data.id)
        }
        this.$router.push({ name: 'aws-bucket', params: { id: data.id } })
      }

      this.loading = false

      this.$emit('created')
    },
  },

  created() {
    this.$localforage.getItem('region', (err, value) => {
      if (value) {
        this.form.region = value
      }
    })
  },
}
</script>
