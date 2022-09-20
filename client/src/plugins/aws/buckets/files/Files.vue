<template>
  <div>
    <v-row no-gutters align="center">
      <aws-buckets-mini-toggler
        v-for="(header, index) in headers"
        :key="header.value"
        v-model="headers[index].show"
        :label="header.text"
        dense
        class="mr-4"
        @input="saveLocal"
      ></aws-buckets-mini-toggler>
    </v-row>

    <v-data-table
      v-model="selected"
      :headers="getHeaders"
      :items="items"
      item-key="tableKey"
      show-select
      :show-expand="showExpand"
    >
      <template
        v-slot:[`item.data-table-expand`]="{ item, isExpanded, expand }"
      >
        <m-tooltip
          :value="expandTooltips[item.contentType]"
          :disabled="!expandItems.includes(item.contentType)"
        >
          <v-btn
            :disabled="!expandItems.includes(item.contentType)"
            icon
            @click="expand(!isExpanded)"
          >
            <v-icon>mdi-chevron-{{ isExpanded ? 'up' : 'down' }}</v-icon>
          </v-btn>
        </m-tooltip>
      </template>

      <template v-slot:[`item.url`]="{ value }">
        <m-tooltip value="Click to copy">
          <a
            :href="value"
            target="_blank"
            @click.prevent="copyToClipboard(value)"
            v-text="value"
          ></a>
        </m-tooltip>
      </template>
      <template v-slot:[`item.cloudfront`]="{ value }">
        <m-tooltip value="Click to copy">
          <a
            :href="value"
            target="_blank"
            @click.prevent="copyToClipboard(value)"
            v-text="value"
          ></a>
        </m-tooltip>
      </template>

      <template v-slot:[`item.Owner`]="{ value }">
        <aws-buckets-files-owner-col v-bind="{ value }" />
      </template>

      <template v-slot:[`item.Size`]="{ value }">
        <span class="text-no-wrap">{{ value | size }}</span>
      </template>

      <template v-slot:[`item._actions`]="{ item }">
        <aws-buckets-files-actions v-bind="{ item }" />
      </template>

      <!-- Expanded Row  -->
      <template v-if="!isDragOver" v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length">
          <aws-buckets-files-expanded-row v-bind="{ item }" />
        </td>
      </template>
    </v-data-table>

    <aws-buckets-files-bulk-actions
      v-if="selected.length"
      :value="selected"
      class="mt-n12"
      @deleted="onDeleted"
    />
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
      selected: [],
      headers: [
        {
          text: 'Name',
          value: 'name',
          show: true,
        },
        {
          text: 'URL',
          value: 'url',
          show: true,
        },
        {
          text: 'Key',
          value: 'Key',
          show: false,
        },
        {
          text: 'ETag',
          value: 'ETag',
          show: false,
        },
        {
          text: 'Size',
          value: 'Size',
          show: true,
        },
        {
          text: 'Storage Class',
          value: 'StorageClass',
          show: false,
        },
        {
          text: 'Owner',
          value: 'Owner',
          show: false,
        },
        {
          text: 'Last Modified',
          value: 'LastModified',
          show: false,
        },
        {
          text: 'Actions',
          value: '_actions',
          show: true,
          sortable: false,
          width: 186,
          align: 'end',
        },
      ],
      localKey: 'aws-buckets-files',
      expandItems: ['video', 'audio', 'text', 'image', 'svg'],
      expandTooltips: {
        video: 'Video Tools',
        audio: 'Audio Tools',
        text: 'Code Editor',
        image: 'Image Compressor',
      },
    }
  },
  computed: {
    ...mapGetters({
      items: 'awsBuckets/files',
      data: 'awsBuckets/data',
      images: 'awsBuckets/imagesList',
      isBucketPublic: 'awsBuckets/isBucketPublic',
      form: 'awsBuckets/filesForm',
      access: 'access',
    }),
    togglers() {
      return this.headers.filter((item) => !item.noToggler)
    },
    headerOptions() {
      return this.headers.filter(
        (header) => !header.requires || this.data[header.requires]
      )
    },
    getHeaders() {
      return this.headers.filter((header) => header.show)
    },

    showExpand() {
      return this.access.premium ? true : false
    },
  },

  methods: {
    onDeleted(Keys) {
      // clear removed items, more could have been selected
      for (let i = 0; i < Keys.length; i++) {
        const index = this.selected.findIndex((a) => a.Key === Keys[i])
        if (index > -1) {
          this.selected.splice(index, 1)
        }
      }
    },
    toggleColumn(index) {
      this.headers[index].show = !this.headers[index].show
    },
    saveLocal() {
      const headers = this.headers.map((item) => item.show)
      this.$localforage.setItem(this.localKey, { headers })
    },
    setHeaders(arr) {
      arr.forEach((value, index) => {
        this.headers[index].show = value
      })
    },
  },

  filters: {
    name(Key) {
      return Key.split('/').pop()
    },
    size(value) {
      return prettyBytes(value)
    },
  },

  mounted() {
    this.$localforage.getItem(this.localKey, (err, value) => {
      if (value) {
        this.setHeaders(value.headers)
      }
    })
  },
}
</script>
