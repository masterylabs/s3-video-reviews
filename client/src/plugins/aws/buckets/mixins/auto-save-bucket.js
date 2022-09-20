import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      _asWait: null,
      _asLoading: false,
      _asPendingSave: false,
    }
  },
  computed: {
    ...mapGetters({
      data: 'awsBuckets/data',
    }),
  },
  methods: {
    autoSave() {
      clearTimeout(this._asWait)
      this._asWait = setTimeout(this.autoSave2, 1000)
    },
    autoSave2() {
      if (!this._asLoading) {
        this.autoSave3()
      } else {
        this._asPendingSave = true
      }
    },
    async autoSave3() {
      this._asLoading = true
      const form = { ...this.data }

      const url = `/buckets/${form.id}`
      await this.$app.post(url, form)

      if (this._asPendingSave) {
        this._asPendingSave = false
        return this.autoSave3()
      }

      this._asLoading = false
      // this.$emit('updated', data)
    },
  },
}
