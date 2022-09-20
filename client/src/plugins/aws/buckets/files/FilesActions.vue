<template>
  <v-row no-gutters justify="end" align="center" class="mr-n2 text-no-wrap">
    <template v-if="action === 'delete'">
      <v-btn
        small
        depressed
        color="error"
        :loading="loading === 'delete'"
        @click="doDelete"
        >Delete</v-btn
      >
      <v-btn
        small
        depressed
        :disabled="loading === 'delete'"
        class="ml-1"
        @click="action = ''"
        >Cancel</v-btn
      >
    </template>

    <template v-else>
      <website-index-btn v-if="websiteAccess && isHtml" :item-key="item.Key" />
      <website-error-btn v-if="websiteAccess && isHtml" :item-key="item.Key" />

      <m-tooltip value="Delete">
        <v-btn icon @click="action = 'delete'">
          <v-icon>mdi-trash-can-outline</v-icon>
        </v-btn>
      </m-tooltip>

      <m-tooltip value="Download">
        <v-btn
          small
          icon
          depressed
          :loading="loading === 'download'"
          color="primary"
          @click="download"
        >
          <v-icon>mdi-download</v-icon>
        </v-btn>
      </m-tooltip>
    </template>
  </v-row>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  //
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      action: '',
      loading: '',
      href: '',
    }
  },

  computed: {
    ...mapGetters({
      websiteAccess: 'websiteAccess',
    }),
    isHtml() {
      return this.item.Key.toLowerCase().split('.').pop() === 'html'
    },
  },

  methods: {
    ...mapActions({
      deleteObject: 'awsBuckets/deleteObject',
      downloadObject: 'awsBuckets/downloadObject',
      downloadFile: 'awsBuckets/downloadFile',
    }),

    async download() {
      this.loading = 'download'
      const download = await this.downloadFile(this.item.Key)

      if (!download) {
        return this.$app.error('Unable download')
      }

      setTimeout(() => {
        this.loading = ''
      }, 1000)
    },

    async doDelete() {
      this.loading = 'delete'
      const ok = await this.deleteObject(this.item.Key)

      if (ok) {
        this.$app.success('Deleted!')
        this.action = ''
      } else {
        this.$app.error('Unable to delete file')
      }
      this.loading = ''
    },
  },
}
</script>
