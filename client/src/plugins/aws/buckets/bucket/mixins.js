import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      data: 'awsBuckets/addBucket',
      credentials: 'aws/credentials',
    }),
    form() {
      return this.data.form
    },
    bucketAuth() {
      return {
        region: this.data.form.region,
        credentials: this.credentials,
      }
    },
  },

  methods: {
    ...mapActions({
      clearForm: 'awsBuckets/addBucketClearForm',
    }),
  },
}
