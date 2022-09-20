<template>
  <m-tooltip
    :disabled="loading"
    :value="`Bucket is currently ${!value ? 'private' : 'public'}`"
    open-delay="600"
  >
    <v-switch
      label="public"
      v-model="value"
      v-bind="{ loading }"
      :disabled="loading"
      :color="value ? 'success' : 'grey'"
      @change="change"
      hide-details
      class="mt-0"
    ></v-switch>
  </m-tooltip>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  data() {
    return {
      loading: false,
      value: false,
    }
  },

  computed: {
    ...mapGetters({
      isBucketPublic: 'awsBuckets/isBucketPublic',
      data: 'awsBuckets/data',
    }),
  },

  methods: {
    ...mapActions({
      makeBucketPublic: 'awsBuckets/makeBucketPublic',
      makeBucketPrivate: 'awsBuckets/makeBucketPrivate',
      getBucketStatus: 'awsBuckets/getBucketStatus',
    }),

    async change() {
      this.loading = true
      if (this.isBucketPublic) {
        await this.makeBucketPrivate()
      } else {
        await this.makeBucketPublic()
      }
      this.value = this.isBucketPublic

      await this.updateLocal()

      this.loading = false
    },

    async updateLocal() {
      const is_public = this.isBucketPublic
      this.data.is_public = is_public
      await this.$app.bgPost(`/buckets/${this.data.id}`, { is_public })
    },
  },

  mounted() {
    setTimeout(() => {
      this.value = this.isBucketPublic
    })
  },

  watch: {
    isBucketPublic(value) {
      if (!this.loading) {
        this.value = value
      }
    },
  },
}
</script>
