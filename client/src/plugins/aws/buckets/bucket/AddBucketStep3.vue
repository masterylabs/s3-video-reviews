<template>
  <div>
    <aws-buckets-icon-picker v-model="form.meta.icon" class="my-4" />
    <aws-buckets-color-picker v-model="form.meta.color" class="my-4" />
    <v-divider class="my-5"></v-divider>
    <v-row no-gutters>
      <v-btn color="primary" depressed v-bind="{ loading }" @click="next"
        >Continue
      </v-btn>
      <v-spacer />
      <v-btn @click="data.step = 2">Back</v-btn>
    </v-row>
  </div>
</template>

<script>
import mixin from './mixins'

export default {
  mixins: [mixin],
  data() {
    return {
      loading: false,
    }
  },

  methods: {
    async next() {
      this.loading = true
      const { data } = await this.$app.bgPost('/buckets', this.data.form)

      this.loading = false
      this.$router.push({ name: 'aws-bucket', params: { id: data.id } })
      this.data.dialog = false

      setTimeout(() => {
        this.data.step = 1
        this.clearForm()
      }, 500)
    },
  },
}
</script>
