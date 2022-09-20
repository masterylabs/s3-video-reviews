<template>
  <m-tooltip :value="tooltip">
    <v-chip class="mt-2 mr-2 body-2" small>
      <i-count-up :delay="0" :endVal="filesCount" />
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
      filesCount: 'awsBuckets/filesCount',
      foldersCount: 'awsBuckets/foldersCount',
      bucketObjectsCount: 'awsBuckets/bucketObjectsCount',
    }),
    tooltip() {
      return `${this.foldersCount} folder${
        this.foldersCount !== 1 ? 's' : ''
      } and ${this.filesCount} file${this.filesCount !== 1 ? 's' : ''}`
    },
  },
}
</script>
