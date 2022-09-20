<template>
  <div>
    <div class="text-center py-4 grey lighten-4 my-6">
      <m-tooltip value="Your website URL">
        <a :href="websiteUrl" target="_blank">
          {{ websiteUrl }}
        </a>
      </m-tooltip>
    </div>
    <m-code> websiteUrl: {{ website }} </m-code>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      data: 'awsBuckets/data',
      meta: 'awsBuckets/meta',
      uploads: 'awsBuckets/uploads',
      files: 'awsBuckets/files',
      folders: 'awsBuckets/folders',
      websiteUrl: 'awsBuckets/websiteUrl',
      website: 'awsBuckets/website',
    }),
  },
}
</script>
