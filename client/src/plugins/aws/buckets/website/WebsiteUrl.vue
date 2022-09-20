<template>
  <v-row align="start" justify="end" no-gutters>
    <div>
      <div class="mb-n2 mt-n2 grey--text font-italic caption">Your Website</div>
      <div>
        <a :href="url" class="info--text body-2 text-no-wrap" target="_blank">{{
          url
        }}</a>
      </div>
      <div v-if="more">
        <a
          :href="basicUrl"
          class="info--text body-2 text-no-wrap"
          target="_blank"
          >{{ basicUrl }}</a
        >
      </div>
    </div>
    <v-btn :disabled="!canMore" icon small class="ml-2" @click="more = !more">
      <v-icon>mdi-chevron-{{ more ? 'up' : 'down' }}</v-icon>
    </v-btn>
  </v-row>
  <!-- <div class="px-2">
    <div class="mb-n2 mt-n2 grey--text font-italic caption">Your Website</div>
    <a :href="url" class="info--text body-2 text-no-wrap" target="_blank">{{
      url
    }}</a>
  </div> -->
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      more: false,
    }
  },

  computed: {
    ...mapGetters({
      url: 'awsBuckets/websiteUrl',
      basicUrl: 'awsBuckets/basicWebsiteUrl',
    }),
    canMore() {
      return this.url !== this.basicUrl
    },
  },
}
</script>
