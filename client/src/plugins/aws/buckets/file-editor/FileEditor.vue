<template>
  <v-card
    color="white"
    tile
    :class="fullscreen ? 'file-editor-fullscreen' : ''"
  >
    <code-editor
      v-model="value"
      v-bind="{ ready, height, contentType, fullscreen }"
      :title="item.Key"
      :language="item.type"
      line-numbers
      lang="js"
    >
      <template v-slot:top>
        <v-toolbar dense rounded="square" flat color="grey lighten-3">
          <v-toolbar-title>Code Editor {{ item.name }}</v-toolbar-title>
          <v-spacer />

          <v-btn
            class="mr-3"
            icon
            :disabled="!ready"
            :loading="reloading"
            @click="reload"
          >
            <v-icon>mdi-reload</v-icon>
          </v-btn>

          <v-btn
            v-bind="{ disabled, loading }"
            color="primary"
            class="ml-2"
            @click="save"
            >Save</v-btn
          >
          <slot name="toolbar-append" />
        </v-toolbar>
      </template>
    </code-editor>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  props: {
    fullscreen: Boolean,
    item: {
      type: Object,
      required: true,
    },
    height: {
      type: [String, Number],
      default: 500,
    },
  },
  data() {
    return {
      ready: false,
      loading: false,
      reloading: false,
      savingAsNew: false,
      value: '',
      savedValue: '',
      contentType: '',
    }
  },

  computed: {
    disabled() {
      return this.value === this.savedValue ? true : false
    },
  },

  methods: {
    ...mapActions({
      getFileContents: 'awsBuckets/getFileContents',
      putFileContents: 'awsBuckets/putFileContents',
      saveChangedFile: 'awsBuckets/saveChangedFile',
    }),

    async reload() {
      this.reloading = true
      this.ready = false
      await this.getContents()
      this.ready = true
      this.reloading = false
    },

    async save() {
      this.loading = true

      const item = {
        Key: this.item.Key,
        contentType: this.contentType,
        contents: this.value,
      }

      const success = await this.putFileContents(item)

      this.loading = false

      if (success) {
        this.savedValue = item.contents
        this.$app.success('Saved!')
      } else {
        this.$app.error('Unable to save')
      }
    },

    async getContents() {
      const body = await this.getFileContents(this.item.Key)

      this.contentType = body.contentType
      this.value = body.value
      this.savedValue = body.value
    },
  },

  async created() {
    await this.getContents()
    this.ready = true
  },
}
</script>

<style scoped>
.file-editor-fullscreen {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100vh;
  z-index: 100;
  /* opacity: 1; */
}
</style>
