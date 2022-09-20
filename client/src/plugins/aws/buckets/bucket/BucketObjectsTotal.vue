<template>
  <m-tooltip value="Total items in this bucket">
    <v-chip class="mt-1 mr-2 body-2" small>
      <i-count-up :delay="0" :endVal="bucketObjectsCount" />
    </v-chip>
  </m-tooltip>
</template>

<script>
import iCountUp from 'vue-countup-v2'
import { mapGetters } from 'vuex'
export default {
  components: {
    iCountUp,
  },
  computed: {
    ...mapGetters({
      bucketObjectsCount: 'awsBuckets/bucketObjectsCount',
    }),
  },
}
</script>
