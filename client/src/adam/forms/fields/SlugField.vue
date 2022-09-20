<template>
  <v-text-field
    :label="label"
    v-model="model"
    :loading="loading"
    :append-icon="checked && value ? 'mdi-check' : ''"
    :hide-details="hideDetails"
    @keyup="onKeyup"
    @blur="$emit('blur')"
  />
</template>

<script>
export default {
  props: {
    hideDetails: Boolean,
    value: {
      type: String,
      default: '',
    },
    url: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      default: 'URL Slug',
    },
  },

  data() {
    return {
      model: '',
      loading: false,
      checked: !!this.value,
      checkValue: '',
      chekedValue: '',
      wait: null,
    }
  },

  beforeMount() {
    this.model = this.value
  },

  methods: {
    onKeyup({ target }) {
      if (!target.value) {
        return this.$emit('input', '')
      }

      if (target.value && target.value !== this.checkValue) {
        this.queCheck(target.value)
      }
    },
    queCheck(value) {
      clearTimeout(this.wait)

      this.checkValue = value
      this.checked = false

      this.wait = setTimeout(() => {
        this.doCheck()
      }, 500)
    },

    async doCheck() {
      this.loading = true

      const form = { slug: this.checkValue }

      const { data } = await this.$app.get(this.url, form)

      // has not changed
      if (form.slug === this.checkValue) {
        this.chekedValue = data
        this.model = data
        this.$emit('input', data)
        this.checked = true
        this.loading = false
      }
    },
  },

  watch: {
    value(slug) {
      if (slug && slug !== this.checkedValue) {
        this.queCheck(slug)
      }
    },
  },
}
</script>
