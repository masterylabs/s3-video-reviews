<template>
  <m-tooltip value="Static website active">
    <v-icon
      size="22"
      :color="value ? 'success' : 'grey lighten-1'"
      class="ml-1 mr-2 mt-n4"
      >mdi-web
    </v-icon>
  </m-tooltip>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      value: 'awsBuckets/isBucketPublic',
    }),
  },
}
</script>
