<template>
  <div>
    <div class="title">Bucket Preview</div>

    <iframe
      ref="preview"
      src="http://localhost:8080/live.html"
      frameborder="0"
      style="width: 100%; height: 800px"
      class="elevation-12"
      @load="onIframeLoaded"
    ></iframe>
    <!-- <adam-bucket-url /> -->

    <!-- <v-textarea
      :value="`export default ${JSON.stringify(adam.page.body)}`"
    ></v-textarea> -->

    <!-- <m-code title="bucketAuth">
      {{ bucketAuth }}
    </m-code>

    <m-code title="Bucket API">
      {{ bucketApi }}
    </m-code>
 -->
    <!-- <m-code title="State">
      {{ adam.page.body }}
    </m-code> -->
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
// import { getJson } from '@/plugins/helpers'
export default {
  computed: {
    ...mapState({
      adam: 'adam',
    }),
    ...mapGetters({
      bucketApi: 'adam/bucketApi',
      bucketAuth: 'adam/bucketAuth',
    }),
  },

  methods: {
    ...mapActions({
      setupBucket: 'adam/setupBucket',
      saveBucket: 'adam/saveBucket',
    }),

    onIframeLoaded() {
      this.updatePreview()
    },

    updatePreview() {
      const previewContent = this.bucketApi
      const msg = JSON.stringify({ previewContent })
      this.$refs.preview.contentWindow.postMessage(msg)
    },
  },
  mounted() {
    //
  },
}
</script>
