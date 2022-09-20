<template>
  <div>
    <v-row>
      <v-col
        v-for="item in items"
        :key="item.Key"
        cols="12"
        sm="6"
        md="4"
        lg="3"
        xl="2"
      >
        <aws-buckets-files-grid-view-item v-bind="{ item }" />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import prettyBytes from 'pretty-bytes'
import copyToClipboardMixin from '@/mixins/copy-to-clipboard'
export default {
  mixins: [copyToClipboardMixin],
  props: {
    isDragOver: Boolean,
  },
  data() {
    return {
      //
    }
  },
  computed: {
    ...mapGetters({
      items: 'awsBuckets/files',
      //   data: 'awsBuckets/data',
      //   images: 'awsBuckets/imagesList',
      //   isBucketPublic: 'awsBuckets/isBucketPublic',
      //   form: 'awsBuckets/filesForm',
      //   access: 'access',
    }),
  },

  methods: {
    //
  },

  filters: {
    name(Key) {
      return Key.split('/').pop()
    },
    size(value) {
      return prettyBytes(value)
    },
  },
}
</script>
