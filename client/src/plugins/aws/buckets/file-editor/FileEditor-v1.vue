<template>
  <v-card color="grey" :class="fullscreen ? 'file-editor-fullscreen' : ''">
    <code-editor
      v-model="value"
      v-bind="{ ready, height, contentType, fullscreen }"
      :title="item.Key"
      :language="item.type"
      line-numbers
      lang="js"
    />

    <v-btn
      v-bind="{ disabled, loading }"
      absolute
      right
      top
      color="primary"
      class="mt-6"
      @click="save"
    >
      Save
    </v-btn>
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
    }),

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
  },

  async created() {
    const body = await this.getFileContents(this.item.Key)

    this.contentType = body.contentType
    this.value = body.value
    this.savedValue = body.value
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
  z-index: 9999;
}
</style>
