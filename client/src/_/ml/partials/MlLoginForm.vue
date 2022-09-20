<template>
  <form @submit.prevent="submit">
    <v-text-field v-model="form.email" :label="m.lang.EMAIL" autofocus />
    <v-text-field
      v-model="form.password"
      :label="m.lang.PASSWORD"
      :type="showPass ? 'text' : 'password'"
      :append-icon="`mdi-eye${!showPass ? '-off' : ''}`"
      @click:append="showPass = !showPass"
    />
    <v-btn
      block
      color="primary"
      type="submit"
      :loading="loading"
      :disabled="!valid"
      class="mb-7 text-none"
    >
      <slot />
    </v-btn>
  </form>
</template>

<script>
  import isEmail from 'validator/lib/isEmail'
  export default {
    props: {
      endpoint: {
        type: String,
        required: true,
      },
    },

    data() {
      return {
        showPass: false,
        loading: false,
        form: {
          email: '',
          password: '',
        },
      }
    },

    computed: {
      valid() {
        return this.form.password && isEmail(this.form.email) ? true : false
      },
    },

    methods: {
      async submit() {
        if (!this.valid) return
        this.loading = true
        try {
          const response = await this.$app.post(this.endpoint, this.form)
          if (response) this.$emit('success', response)
        } finally {
          this.loading = false
        }
      },
    },
  }
</script>
