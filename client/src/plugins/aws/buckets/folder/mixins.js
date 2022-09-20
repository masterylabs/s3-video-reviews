import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      data: 'awsBuckets/folder',
      credentials: 'aws/credentials',

      // folder

      folders: 'awsBuckets/folders',
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
      clearForm: 'awsBuckets/clearFolderForm',
    }),
  },
}
