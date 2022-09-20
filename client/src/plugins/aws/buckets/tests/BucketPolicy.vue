<template>
  <div>
    <v-switch
      label="Public"
      v-model="value"
      v-bind="{ loading }"
      :color="value ? 'success' : 'grey'"
      @change="change"
    ></v-switch>
    Test Bucket Policy
    <div>
      <v-btn @click="makeBucketPublic">make Public</v-btn>
      <v-btn @click="makeBucketPrivate">makeBucketPrivate</v-btn>
    </div>

    <v-btn @click="putBucketPolicy">putBucketPolicy</v-btn>
    <v-btn @click="deleteBucketPolicy">deleteBucketPolicy</v-btn>
    <v-btn @click="getBucketPublicAccess">getBucketPublicAccess</v-btn>
    <v-btn @click="putBucketPublicAccess">putBucketPublicAccess</v-btn>

    isBucketPublicPolicy: {{ isBucketPublicPolicy }} <br />
    isBucketPublicAccess: {{ isBucketPublicAccess }} <br />
    isBucketPublic: {{ isBucketPublic }}
    <m-code>
      {{ bucketStatus }}
    </m-code>

    <img src="https://wp-bucket-test-3.s3.amazonaws.com/image-one.png" alt="" />
  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex'
export default {
  data() {
    return {
      loading: false,
      value: false,
    }
  },

  computed: {
    ...mapState({
      aws: 'awsBuckets',
    }),
    ...mapGetters({
      bucketStatus: 'awsBuckets/bucketStatus',
      isBucketPublicPolicy: 'awsBuckets/isBucketPublicPolicy',
      isBucketPublicAccess: 'awsBuckets/isBucketPublicAccess',
      isBucketPublic: 'awsBuckets/isBucketPublic',
    }),
  },

  methods: {
    ...mapActions({
      getBucketPolicy: 'awsBuckets/getBucketPolicy',
      putBucketPolicy: 'awsBuckets/putBucketPolicy',
      deleteBucketPolicy: 'awsBuckets/deleteBucketPolicy',
      getBucketPublicAccess: 'awsBuckets/getBucketPublicAccess',
      putBucketPublicAccess: 'awsBuckets/putBucketPublicAccess',
      makeBucketPublic: 'awsBuckets/makeBucketPublic',
      makeBucketPrivate: 'awsBuckets/makeBucketPrivate',
      getBucketStatus: 'awsBuckets/getBucketStatus',
    }),

    async change(value) {
      this.loading = true
      if (this.isBucketPublic) {
        await this.makeBucketPrivate()
      } else {
        await this.makeBucketPublic()
      }
      this.value = this.isBucketPublic
      this.loading = false
    },
  },

  async mounted() {
    // this.loading = true
    // await this.getBucketStatus()
    //
    // this.value = this.isBucketPublic
    // this.loading = false
    //
    // const policy = await this.getBucketPolicy()
    // if (!policy) {
    //
    // }
    //
    // await this.getBucketStatus()
    //
  },
}
</script>
