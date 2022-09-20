<template>
  <div>
    TEST
    <aws-buckets-add-bucket-form />
    <m-code> {{ auth }}</m-code>
    <m-code> {{ res }} </m-code>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      res: null,
    }
  },

  computed: {
    ...mapGetters({
      auth: 'aws/auth',
    }),
  },

  methods: {
    ...mapActions({
      getBuckets: 'aws/getBuckets',
    }),
  },

  async mounted() {
    // this.res = await this.getBuckets()
  },
}
</script>
