<template>
  <v-card width="300">
    <v-card-text>
      LOGIN FORM
      <form @submit.prevent="submit">
        <v-text-field label="Email"></v-text-field>
        <v-text-field label="Password"></v-text-field>
        <v-btn v-bind="{ loading }" type="submit">Login</v-btn>
      </form>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
    }
  },

  methods: {
    async submit() {
      this.loading = true

      const res = await this.$app.post('/login')
    },
  },
}
</script>
