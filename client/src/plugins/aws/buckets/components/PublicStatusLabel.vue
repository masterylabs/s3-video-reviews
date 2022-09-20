<template>
  <span>
    <v-chip
      v-if="ready"
      label
      x-small
      class="ml-1 px-2 text-uppercase font-weight-medium rounded-0 mt-n4"
      :color="value ? 'success' : 'error'"
      >{{ value ? 'public' : 'private' }}
    </v-chip>
    <website-public-icon v-if="websiteEnabled" />
  </span>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      value: 'awsBuckets/isBucketPublic',
      ready: 'awsBuckets/bucketStatusReady',
      websiteEnabled: 'awsBuckets/websiteEnabled',
    }),
  },
}
</script>
