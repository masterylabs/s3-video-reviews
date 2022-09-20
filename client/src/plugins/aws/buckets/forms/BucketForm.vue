<template>
  <div>
    <!-- <aws-buckets-color-field
      v-model="meta.color"
      @input="onChange"
      class="mx-n1"
    />
    <aws-buckets-icon-field
      v-model="meta.icon"
      @input="onChange"
      class="mb-5"
    />
    <v-text-field
      v-model="meta.displayName"
      label="Display Name"
      :placeholder="item.name"
      @input="onChange"
    />

    <m-delete-btn
      depressed
      icon
      justify="end"
      :loading="deleting"
      @confirm="deleteItem"
      class="mt-6"
    >
      Delete Locally
    </m-delete-btn> -->
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      changeWait: null,
      loading: false,
      pendingSave: false,
      deleting: false,
      item: {
        meta: {},
      },
    }
  },

  computed: {
    meta() {
      return this.item.meta || {}
    },
  },

  methods: {
    onChange() {
      clearTimeout(this.changeWait)
      this.changeWait = setTimeout(() => {
        if (!this.loading) {
          this.saveChanges()
        } else {
          this.pendingSave = true
        }
      }, 1000)
    },

    async saveChanges() {
      this.loading = true
      let url = '/buckets'
      if (this.value && this.value.id) {
        url += `/${this.value.id}`
      }

      const { data } = await this.$app.post(url, this.item)

      if (this.pendingSave) {
        this.pendingSave = false
        return this.saveChanges()
      }

      this.loading = false
      this.$emit('updated', data)
    },

    async deleteItem() {
      // return
      this.deleting = true
      await this.$app.post(`/buckets/${this.item.id}/delete`)
      this.deleting = false

      this.$emit('deleted')
    },
  },

  created() {
    if (this.value) {
      this.item = { ...this.value }
    }
  },
}
</script>
