<template>
  <v-card>
    <div class="grey lighten-3">
      <v-toolbar flat dense color="transparent">
        <v-toolbar-title> Image Compressor</v-toolbar-title>

        <v-spacer />

        <v-btn
          class="mr-3"
          icon
          :disabled="!ready"
          :loading="reloading"
          @click="reloadImage"
        >
          <v-icon>mdi-reload</v-icon>
        </v-btn>
        <v-btn
          v-if="ready && url"
          v-bind="{ disabled: !canSave || savingAsNew, loading }"
          color="primary"
          @click="save"
        >
          Save
        </v-btn>
        <v-btn
          v-bind="{ disabled: !canSave, loading: savingAsNew }"
          color="primary"
          class="ml-2"
          @click="saveAsNew"
          >Save New</v-btn
        >
        <slot name="toolbar-append" />
      </v-toolbar>

      <!-- <v-card-text> -->
      <v-row v-if="!ready" style="height: 300px" no-gutters>
        <m-loading-circle />
      </v-row>

      <div v-if="ready && !url" class="text-center pa-6">
        <div class="body-1 mb-4">Unable to get image</div>
        <v-btn depressed :loading="loading" @click="getUrl">Try Again</v-btn>
      </div>
      <!-- </v-card-text> -->
    </div>

    <v-fade-transition>
      <image-compressor
        v-if="ready && url"
        v-bind="{ url, fileName: item.name, title: item.name }"
        no-bar
        @input="onInput"
        @failed="url = ''"
        @ready="compressorReady = true"
      />
    </v-fade-transition>
  </v-card>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      ready: false,
      compressorReady: false,
      loading: false,
      savingAsNew: false,
      reloading: false,
      // formatChanged: false,
      sizeImprovement: 0,
      url: '',
      file: null,
    }
  },

  computed: {
    ...mapGetters({
      path: 'awsBuckets/path',
    }),
    disabled() {
      return !this.file
    },
    canSave() {
      if (!this.file) {
        return false
      }
      return this.sizeImprovement !== 0 || this.formatChanged ? true : false
    },
    formatChanged() {
      return this.file && this.file.name && this.file.name !== this.item.name
        ? true
        : false
    },
  },

  methods: {
    ...mapMutations({
      setObjectProp: 'awsBuckets/SET_OBJECT_PROP',
    }),
    ...mapActions({
      getFileContents: 'awsBuckets/getFileContents',
      putFileContents: 'awsBuckets/putFileContents',
      getDownloadUrl: 'awsBuckets/getDownloadUrl',
      saveChangedFile: 'awsBuckets/saveChangedFile',
    }),

    async reloadImage() {
      this.reloading = true
      this.ready = false
      await this.getUrl()

      this.ready = true
      this.reloading = false
    },

    onInput(e) {
      this.file = e.file
      this.sizeImprovement = e.improvement
    },

    async save() {
      const formatChanged = this.formatChanged

      this.loading = true

      let success = false

      // replace with new file

      if (formatChanged) {
        success = await this.saveChangedFile({
          newFile: this.file,
          oldItem: this.item,
          keep: false,
        })
      }

      // update contents
      else {
        const item = {
          Key: this.item.Key,
          contentType: this.file.type,
          contents: this.file,
        }

        success = await this.putFileContents(item)
      }

      this.loading = false

      if (success) {
        this.$app.success('Saved!')
        if (!formatChanged) {
          this.setObjectProp([this.item.Key, { Size: this.file.size }])
        }

        this.file = null
      } else {
        this.$app.error('Unable to save')
      }
    },

    async saveAsNew() {
      this.savingAsNew = true

      const success = await this.saveChangedFile({
        newFile: this.file,
        oldItem: this.item,
        keep: true,
      })

      if (success) {
        this.$app.success('Saved!')
        this.file = null
      } else {
        this.$app.error('Unable to save')
      }

      this.savingAsNew = false
    },

    async getUrl() {
      this.loading = true
      try {
        this.url = await this.getDownloadUrl(this.item.Key)
      } catch {
        this.$app.error('Unable to get image')
      }

      this.loading = false
    },
  },

  async created() {
    await this.getUrl()
    // this.ready = true
    setTimeout(() => {
      this.ready = !this.ready
    }, 1000)
  },
}
</script>
